<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\Famille;
use App\Models\Membre;
use App\Models\ListeSouhait;

class ListeSouhaitController extends Controller
{
    protected $rules = [
        'annee' => ['required', 'year']
    ];

    public function index()
    {
    }

    public function show($id)
    {
        $membre = Membre::find($id);
        $famille = Famille::find($membre->id_famille);
        
        $listes = ListeSouhait::getForMembre($id);
        
        $page_title = 'Les listes de souhaits de : ' . $membre->prenom .' ' . $famille->nom;

        $view = new View('listes_souhaits');
        $view->render(compact('listes', 'page_title', 'membre', 'famille'));
    }

    public function create($id_membre)
    {
        $membre = Membre::find($id_membre);
        $page_title = "Création d'une nouvelle liste";
        
        $view = new View('liste_create');
        $view->render(compact('membre', 'page_title'));
    }

    public function store($data, $id_membre)
    {
        if ($this->validate($data)) {
            $data['id_membre'] = $id_membre;
            $liste = ListeSouhait::create($data);

            flash('message', "La liste de l'année {$liste->annee} a bien été créé.");
            $this->redirect("membre/{$id_membre}/listes");
        } else {
            $this->redirect("membre/{$id_membre}/listes/create");
        }
    }

    public function edit($id)
    {
        $liste = ListeSouhait::find($id);

        $page_title = "Modification de la liste de {$liste->annee}";
        
        $view = new View('liste_edit');

        $view->render(compact('liste', 'page_title'));
    }

    public function update($data, $id)
    {
        if ($this->validate($data)) {
            $liste = ListeSouhait::update($data, $id);

            flash('message', "La liste a bien été modifié.");

            $this->redirect("membre/{$liste->id_membre}/listes");
        } else {
            $this->redirect("liste/{$id}/edit");
        }
    }

    public function destroy($id)
    {
        $liste = ListeSouhait::find($id);
        ListeSouhait::deleteAllFromListe($id);
        flash('message', "La liste de {$liste->annee} ainsi que les souhaits associés ont bien été supprimé.");
        $this->redirect("membre/{$liste->id_membre}/listes");
    }
}
