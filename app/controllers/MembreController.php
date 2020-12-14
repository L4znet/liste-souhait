<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\Famille;
use App\Models\Membre;

class MembreController extends Controller
{
    protected $rules = [
        'prenom' => 'required',
        'date_naissance' => 'required',
    ];

    public function index()
    {
    }


    public function create($id_famille)
    {
        $famille = Famille::find($id_famille);

        $page_title = "Ajout d'un nouveau membre";
        
        $view = new View('membre_create');
        $view->render(compact('famille', 'page_title'));
    }

    public function store($data, $id_famille)
    {
        if ($this->validate($data)) {
            $data['id_famille'] = $id_famille;
            $membre = Membre::create($data);
            flash('message', "Le membre {$membre->prenom} a bien été ajouté.");
            $this->redirect("famille/{$id_famille}");
        } else {
            $this->redirect("famille/{$id_famille}/membre/create");
        }
    }

    public function edit($id)
    {
        $membre = Membre::find($id);
        $famille = Famille::find($membre->id_famille);
        $membre->nom = $famille->nom;
        $page_title = "Modification de {$membre->prenom} {$famille->nom}";
        
        $view = new View('membre_edit');

        $view->render(compact('membre', 'page_title'));
    }

    public function update($data, $id)
    {
        if ($this->validate($data)) {
            $membre = Membre::update($data, $id);

            flash('message', "Le membre {$membre->prenom} {$membre->nom} a bien été modifié.");

            $this->redirect("famille/{$membre->id_famille}");
        } else {
            $this->redirect("membre/{$membre->id}/edit");
        }
    }

    public function destroy($id)
    {
        $membre = Membre::find($id);
        Membre::deleteAllFromMembre($id);
        $famille = Famille::find($membre->id_famille);
       
        flash('message', "{$membre->prenom} {$famille->nom} ainsi que ses listes et ses souhaits ont bien été supprimé.");
        $this->redirect("famille/{$membre->id_famille}");
    }
}
