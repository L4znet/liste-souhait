<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\ListeSouhait;
use App\Models\Souhait;

class SouhaitController extends Controller
{
    protected $rules = [
        'title' => 'required',
        'text' => 'required',
    ];

    public function index()
    {
    }

    public function show($id)
    {
        $liste_souhaits = ListeSouhait::find($id);
        $souhaits = Souhait::getForListe($id);
        
        $page_title = 'La liste de ' . $liste_souhaits->annee;

        $view = new View('liste_souhaits');
        $view->render(compact('souhaits', 'page_title', 'liste_souhaits'));
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
