<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\Famille;

class HomeController extends Controller
{
    public function index()
    {
        $page_title = 'Bienvenue';
        $familles = Famille::get();
        $view = new View('home');
        $data = compact('familles', 'page_title');
        $view->render($data);
    }
}
