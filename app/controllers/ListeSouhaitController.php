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
        'title' => 'required',
        'text' => 'required',
    ];

    public function index()
    {
    }

    public function show($id, $id_famille)
    {
        $famille = Famille::find($id_famille);
        $membre = Membre::find($id);
        $listes = ListeSouhait::getForMembre($id);
        
        $page_title = 'Les listes de souhaits de : ' . $membre->prenom .' ' . $famille->nom;

        $view = new View('listes_souhaits');
        $view->render(compact('listes', 'page_title', 'membre', 'famille'));
    }

    public function create()
    {
        $page_title = 'Nouvel article';
        
        $view = new View('article-create');
        $view->render(compact('page_title'));
    }

    public function store($data)
    {
        if ($this->validate($data)) {
            $article = Article::create($data);

            flash('message', "L'article {$article->title} a bien été créé.");

            $this->redirect("article/{$article->id}");
        } else {
            $this->redirect("article/create");
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);

        $page_title = "Modification de l'article {$article->title}";
        
        $view = new View('article-edit');

        $view->render(compact('article', 'page_title'));
    }

    public function update($data, $id)
    {
        if ($this->validate($data)) {
            $article = Article::update($data, $id);

            flash('message', "L'article {$article->title} a bien été modifié.");

            $this->redirect("article/{$id}");
        } else {
            $this->redirect("article/{$id}/edit");
        }
    }

    public function destroy($id)
    {
        Article::destroy($id);
        flash('message', "L'article a bien été supprimé.");
        $this->redirect("article");
    }
}
