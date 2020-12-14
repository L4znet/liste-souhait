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

    public static function deleteAllFromMembre($id_membre)
    {
        $query_builder = QueryBuilder::model(Membre::class);
        $query_builder->where('id_membre', $id_membre)->delete();

        $query_builder = QueryBuilder::model(ListeSouhait::class);
        $liste = $query_builder->whereNotDeleted()->where('id_membre', $id_membre)->first();
        $query_builder->where('id_membre', $id_membre)->delete();
        
        $query_builder = QueryBuilder::model(Souhait::class);
        $query_builder->where('id_liste', $liste->id)->delete();
    }
}
