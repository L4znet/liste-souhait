<?php

namespace App\Models;

use PDO;
use Core\Model;
use Core\QueryBuilder;

class Membre extends Model
{
    public static function getForFamille($id_famille)
    {
        $query_builder = QueryBuilder::model(Membre::class);
        return $query_builder->where('id_famille', $id_famille)->orderByDesc('created_at')->get();
    }
}
