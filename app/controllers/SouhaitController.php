<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\Membre;
use App\Models\ListeSouhait;
use App\Models\Souhait;
use App\Models\Famille;

class SouhaitController extends Controller
{
    protected $rules = [
        'nom' => 'required'
    ];

    public function index()
    {
    }



    private function getDonneur($obj, $default, $loop)
    {
        if ($loop) {
            for ($i = 0; $i < count((array)$obj); $i++) {
                if ($obj[$i]->id_donneur != "") {
                    $membre = Membre::find($obj[$i]->id_donneur);
                    $famille = Famille::find($membre->id_famille);
                    $obj[$i]->donneur_nom = $membre->prenom . ' ' . $famille->nom;
                    $obj[$i]->donneur_id = $membre->id;
                } else {
                    $obj[$i]->donneur_nom = $default;
                    $obj[$i]->donneur_id = null;
                }
            }
        } else {
            if ($obj->id_donneur != "") {
                $membre = Membre::find($obj->id_donneur);
                $famille = Famille::find($membre->id_famille);
                $obj->donneur_nom = $membre->prenom . ' ' . $famille->nom;
                $obj->donneur_id = $membre->id;
            } else {
                $obj->donneur_nom = $default;
                $obj->donneur_id = null;
            }
        }
    }

    public function show($id)
    {
        $liste_souhaits = ListeSouhait::find($id);
        $souhaits = Souhait::getForListe($id);
        $membres = Membre::get();
        $this->getDonneur($souhaits, "Choix de la personne", true);

        $page_title = 'La liste de ' . $liste_souhaits->annee;
        $view = new View('liste_souhaits');
        $view->render(compact('souhaits', 'page_title', 'liste_souhaits', 'membres'));
    }

    public function create($id_liste)
    {
        $liste = ListeSouhait::find($id_liste);
        $page_title = 'Ajouter un souhait';


        $view = new View('souhait_create');
        $view->render(compact('page_title', 'liste'));
    }

    public function store($data, $id_liste)
    {
        if ($this->validate($data)) {
            $data['id_liste'] = $id_liste;
            if (empty($data['lien'])) {
                $data['lien'] = null;
            }
            if (empty($data['prix'])) {
                $data['prix'] = null;
            }
            $souhait = Souhait::create($data);
            
            if (empty($data['lien'])) {
                $souhait->show = "d-none";
            }
            if (empty($data['prix'])) {
                $souhait->show = "d-none";
            }
            flash('message', "{$souhait->nom} a bien été ajouté à la liste.");

            $this->redirect("liste/{$souhait->id_liste}/souhait");
        } else {
            $this->redirect("liste/{$souhait->id_liste}/souhait/create");
        }
    }



    public function edit($id)
    {
        $souhait = Souhait::find($id);
        $membres = Membre::get();
        
        $this->getDonneur($souhait, "Choix de la personne", false);

        $page_title = "Modification du produit {$souhait->nom}";
        $view = new View('souhait-edit');
        $view->render(compact('souhait', 'page_title', 'membres'));
    }

    public function update($data, $id)
    {
        if ($this->validate($data)) {
            $souhait = Souhait::update($data, $id);

            flash('message', "Le souhait {$souhait->nom} a bien été modifié.");

            $this->redirect("liste/{$souhait->id_liste}/souhait");
        } else {
            $this->redirect("liste/souhait/cadeau/{$souhait->id}");
        }
    }

    public function destroy($id)
    {
        $souhait = Souhait::find($id);
        Souhait::destroy($id);
        flash('message', "{$souhait->nom} a bien été supprimé.");
        $this->redirect("liste/{$souhait->id_liste}/souhait");
    }
}
