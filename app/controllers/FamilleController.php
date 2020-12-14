<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\Famille;
use App\Models\Membre;
use App\Models\ListeSouhait;
use App\Models\Souhait;

class FamilleController extends Controller
{
    protected $rules = [
        'nom' => 'required',
        'ville' => 'required',
    ];

    public function index()
    {
    }

    public function show($id)
    {
        $famille = Famille::find($id);
        $membres = Membre::getForFamille($id);
        
        if (isset($famille->nom)) {
            $page_title = 'La famille : ' . $famille->nom;
        } else {
            $page_title = "";
        }
       
        $view = new View('famille');
        $view->render(compact('famille', 'page_title', 'membres'));
    }

    public function create()
    {
        $page_title = 'Nouvelle famille';
        
        $view = new View('famille_create');
        $view->render(compact('page_title'));
    }

    public function store($data)
    {
        if ($this->validate($data)) {
            $famille = Famille::create($data);
            flash('message', "La famille {$famille->nom} a bien été créé.");
            $this->redirect("/");
        } else {
            $this->redirect("famille/create");
        }
    }

    public function edit($id)
    {
        $famille = Famille::find($id);

        $page_title = "Modification de l'article {$famille->nom}";
        
        $view = new View('famille-edit');

        $view->render(compact('famille', 'page_title'));
    }

    public function update($data, $id)
    {
        if ($this->validate($data)) {
            $famille = Famille::update($data, $id);

            flash('message', "La famille {$famille->nom} a bien été modifié.");

            $this->redirect("/");
        } else {
            $this->redirect("famille/{$id}/edit");
        }
    }

    public function destroy($id)
    {
        Famille::deleteAllFromFamille($id);
        Famille::destroy($id);
        flash('message', "La famille {$famille->nom} ainsi que l'ensemble du contenu rattaché ont bien été supprimé.");
        $this->redirect("/");
    }
}
