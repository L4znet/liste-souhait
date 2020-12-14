<?php

namespace Core;

use PDO;

class QueryBuilder
{

    /**
     * USAGE :
     * $query_buidler = QueryBuilder::model('App\Models\Article');
     * $query_builder->where('title', 'test')->orberByAsc('created_at')->get();
     */

    protected static $connexion = null; // Connexion PDO
    protected $query; // PDOStatement
    protected $type; // Type de la requête : select, select_once, insert, update, delete

    protected $model; // Modèle utilisé par le builder
    protected $table; // Table utilisée par le builder
    protected $columns; // Liste des colonnes à retourner pour un select
    protected $data = []; // Données à insérer ou mettre à jour dans la table (update et insert)
    protected $binding = []; // Données à binder dans la requête (tokens)
    protected $wheres = []; // Tableau contenant tous les "WHERE"
    protected $orders = []; // Tableau contenant tous les "ORDER BY"

    /**
     * Le constructeur crée la connexion à la DB
     */
    public function __construct()
    {
        // Connexion à la BDD si nécessaire
        if (empty(self::$connexion)) {
            self::$connexion = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USER, DB_PWD);
        }
    }

    /**
     * Permet d'instancier un builder sur la table souhaitée (sans modèle)
     */
    public static function table($table)
    {
        $builder = new QueryBuilder();
        $builder->table = $table;

        return $builder;
    }

    /**
     * Permet d'instancier un builder sur la table souhaitée
     * par rapport au nom du modèle passé en paramètre
     */
    public static function model($model)
    {
        $builder = new QueryBuilder();

        $builder->model = $model;

        // On récupère la table associée au modèle (ou on la devine si elle n'est pas spécifiée)
        if (!empty($builder->model::$table_name)) {
            $builder->table = $builder->model::$table_name;
        } else {
            $tmp = explode('\\', $builder->model);
            $model = array_pop($tmp);
            $builder->table = strtolower($model) . 's';
        }

        return $builder;
    }

    /**
     * Cette méthode permet d'ajouter un critère à la requête en cours
     */
    public function where($field, $value, $operator = '=')
    {
        $token = $this->bind($field, $value);

        // On ajoute au tableau de where une string de type "field = :token"
        $this->wheres[] = "{$field} {$operator} {$token}";

        // On retourne le builder pour assurer le chaînage
        return $this;
    }

    /**
     * Cette méthode permet d'ajouter un critère de filtre sur le soft delete
     */
    public function whereNotDeleted()
    {
        $this->wheres[] = "deleted_at IS NULL";

        // On retourne le builder pour assurer le chaînage
        return $this;
    }

    /**
     * Cette méthode permet d'ajouter un tri ascendant sur un champ passé en paramètre
     */
    public function orderByAsc($field)
    {
        $this->orders[] = "{$field} ASC";

        // On ajoute au tableau de where une string de type "field = :token"
        return $this;
    }

    /**
     * Cette méthode permet d'ajouter un tri descendant sur un champ passé en paramètre
     */
    public function orderByDesc($field)
    {
        $this->orders[] = "{$field} DESC";

        // On ajoute au tableau de where une string de type "field = :token"
        return $this;
    }

    /**
     * Cette méthode va executer la requête du builder en tant que SELECT, et retournera uniquement la 1ere ligne
     */
    public function first($columns = '*')
    {
        $this->type = 'select_one';
        $this->columns = $columns;

        return $this->execute();
    }

    /**
     * Cette méthode va executer la requête du builder en tant que SELECT, et retournera toutes les lignes
     */
    public function get($columns = '*')
    {
        $this->type = 'select';
        $this->columns = $columns;

        return $this->execute();
    }

    /**
     * Cette méthode va executer la requête du builder en tant qu'INSERT
     */
    public function insert($data)
    {
        $this->type = 'insert';

        // Ajout des données à mette à jour dans le binding
        $this->data = $data;
        
        return $this->execute();
    }

    /**
     * Cette méthode va executer la requête du builder en tant qu'UPDATE
     */
    public function update($data)
    {
        $this->type = 'update';

        // Avant exécution, on ajoute au binding la date en cours pour permettre la mise à jour de la colonne updated_at
        $this->data = array_merge($data, ['updated_at' => date('Y-m-d H:i:s')]);
        
        $this->execute();
    }

    /**
     * Cette méthode va executer la requête du builder en tant que DELETE
     */
    public function delete()
    {
        $this->type = 'delete';
        
        $this->execute();
    }

    /**
     * Stocke la donnée à binder dans un tableau, et retourne le token correspondant
     */
    protected function bind($field, $value)
    {
        // On créé le nom d'un token
        $token = ':token_' . $field . '_' . uniqid();

        // On ajoute aux données à binder la valeur du critère
        $this->binding[$token] = $value;

        return $token;
    }

    protected function execute()
    {
        // Création de la requête SQL
        $sql = $this->toSql();

        // Préparation de la requête
        $query = self::$connexion->prepare($sql);
        
        // Exécution de la requête
        $query->execute($this->binding);

        // Selon le type de requête, on adaptera la valeur retournée
        switch ($this->type) {

            case 'insert':
                // Pour un insert, on retourne l'id généré
                return self::$connexion->lastInsertId();
                break;

            case 'select_one':
                // Pour un select_one, on fetche la 1ère ligne dans le modèle ou dans un tableau
                if (!empty($this->model)) {
                    return $query->fetchObject($this->model);
                } else {
                    return $query->fetch(PDO::FETCH_ASSOC);
                }
                break;

            case 'select':
                // Pour un select, on fetche le résultat dans un tableau de modèle ou dans un tableau de tableau
                if (!empty($this->model)) {
                    return $query->fetchAll(PDO::FETCH_CLASS, $this->model);
                } else {
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
                break;

            default:
                // Sinon, on retourne null
                return null;
        }
    }

    protected function toSql()
    {
        // Remplace dans le tableau data les valeurs par le token correspondant
        foreach ($this->data as $field => $value) {
            $this->data[$field] = $this->bind($field, $value);
        }

        switch ($this->type) {

            case 'select_one':
            case 'select':

                $sql = "SELECT {$this->columns} FROM {$this->table}";

                $sql .= $this->toSqlWhere();

                if (!empty($this->orders)) {
                    $sql .= ' ORDER BY ' . implode(', ', $this->orders);
                }

                break;


            case 'insert':

                $fields = implode(', ', array_keys($this->data));
                $tokens = implode(', ', array_values($this->data));
        
                $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$tokens})";
                
            break;

            case 'update':

                $fields = implode(', ', array_map(function ($token, $field) {
                    return $field . ' = ' . $token;
                }, $this->data, array_keys($this->data)));

                $sql = "UPDATE {$this->table} SET {$fields}";

                $sql .= $this->toSqlWhere();

                break;

            case 'delete':

                $sql = "DELETE FROM {$this->table}";

                $sql .= $this->toSqlWhere();
                
                break;

        }

        return $sql;
    }

    protected function toSqlWhere()
    {
        if (!empty($this->wheres)) {
            return ' WHERE ' . implode(' AND ', $this->wheres);
        } else {
            return '';
        }
    }
}
