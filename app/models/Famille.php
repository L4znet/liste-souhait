<?php

namespace App\Models;

use PDO;
use Core\Model;
use Core\QueryBuilder;

class Famille extends Model
{
    public static function deleteAllFromFamille($id_famille)
    {
        $query_builder = QueryBuilder::model(Famille::class);
        $query_builder->where('id', $id_famille)->delete();

        $query_builder = QueryBuilder::model(Membre::class);
        $membre = $query_builder->whereNotDeleted()->where('id_famille', $id_famille)->first();
        $query_builder->where('id_famille', $id_famille)->delete();

        $query_builder = QueryBuilder::model(ListeSouhait::class);
        $liste = $query_builder->whereNotDeleted()->where('id_membre', $membre->id)->first();
        $query_builder->where('id_membre', $membre->id)->delete();
        
        $query_builder = QueryBuilder::model(Souhait::class);
        $souhait = $query_builder->whereNotDeleted()->where('id_liste', $liste->id)->first();
        $query_builder->where('id_liste', $liste->id)->delete();
    }
}
