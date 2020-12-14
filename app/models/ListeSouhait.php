<?php

namespace App\Models;

use PDO;
use Core\Model;
use Core\QueryBuilder;

class ListeSouhait extends Model
{
    public static $table_name = "liste_souhaits";
    public static function getForMembre($id_membre)
    {
        $query_builder = QueryBuilder::model(ListeSouhait::class);
        return $query_builder->where('id_membre', $id_membre)->orderByDesc('created_at')->get();
    }

    public static function deleteAllFromListe($id_liste)
    {
        $query_builder = QueryBuilder::model(ListeSouhait::class);
        $query_builder->where('id', $id_liste)->delete();
        
        $query_builder = QueryBuilder::model(Souhait::class);
        $query_builder->where('id_liste', $id_liste)->delete();
    }
}
