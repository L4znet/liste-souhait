<?php

namespace App\Models;

use PDO;
use Core\Model;
use Core\QueryBuilder;

class Souhait extends Model
{
    public static $table_name = "souhaits";
    public static function getForListe($id_liste)
    {
        $query_builder = QueryBuilder::model(Souhait::class);
        return $query_builder->where('id_liste', $id_liste)->orderByDesc('created_at')->get();
    }
}
