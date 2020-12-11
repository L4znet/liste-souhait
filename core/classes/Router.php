<?php

namespace Core;

use App;

class Router {

    protected $routes = [];


    /**
     * Permet d'ajouter une route supplémentaire au Routeur, qu'il pourra ensuite évaluer via la méthode deal()
     */
    public function add($pattern, $action, $with_post = false)
    {
        $this->routes[$pattern] = [
            'action' => $action, // action sous forme Controller@method
            'with_post' => $with_post, // si vrai, le tableau $_POST sera passé en premier paramètre à l'action corespondant à la route au moment du deal()
        ];
    }

    /**
     * Permet d'ajouter toutes les routes CRUD pour un controller donné
     * Usage : $router->addCrud('user', 'UserController');
     */
    public function addCrud($prefix, $controller)
    {
        $this->add("{$prefix}", "{$controller}@index");
        $this->add("{$prefix}/{num}", "{$controller}@show");
        $this->add("{$prefix}/create", "{$controller}@create");
        $this->add("{$prefix}/store", "{$controller}@store", true);
        $this->add("{$prefix}/{num}/edit", "{$controller}@edit");
        $this->add("{$prefix}/{num}/update", "{$controller}@update", true);
        $this->add("{$prefix}/{num}/destroy", "{$controller}@destroy");
    }

    /**
     * Identifie la route correspondante à l'URI courante, et appelle l'action associée
     */
    public function deal()
    {
        // Récupération de l'URI courante et suppression du BASE_URI
        $uri = $_SERVER['REQUEST_URI'];
        $uri = substr($uri, strlen(BASE_URI));
        $uri = '/' . trim($uri, '/');

        // Pour chaque route enregistré dans le router, on vérifie la correspondance avec l'URI courante
        foreach ($this->routes as $route => $params) {

            // Mapping des masks de regex dans la route
            $masks = [
                '{num}' => '([0-9]+)',
                '{alpha}' => '([a-zA-Z]+)',
                '{alphanum}' => '([a-zA-Z0-9\-]+)',
            ];     

            $route = str_replace(array_keys($masks), $masks, $route);

            // Vérification de la correspondance
        
            if (preg_match('#^/' . $route . '$#', $uri, $matches) === 1) {

                // Isolation du controller et de la méthode

                list($controller_name, $method) = explode('@', $params['action']);

                $controller_name = "App\Controllers\\{$controller_name}";
        
                $controller = new $controller_name();

                // Si le tableau de matches contient plus d'une case, 
                // il y a des éléments capturés dans l'URI à passer au controller
        
                if (count($matches) > 1) {
                    // Création d'un tableau contenant uniquement les captures
                    $args = array_slice($matches, 1);
                }
                else {
                    // Pas de capture, création d'un tableau vide pour permettre l'appel au controlleur
                    $args = [];
                }
        
                // Si cette route nécessite l'envoi du tableau $_POST, on l'ajoute en 1er paramètre
                if ($params['with_post']) {
                    
                    $args = array_merge([$_POST], $args);
                }

                // Appel de la méthode du controller, en passant les paramètres via le tableau d'argument
                call_user_func_array([$controller, $method], $args);
        
                break;
            }
        }
        
        // Si aucune route ne correspond (pas de controller instancié), on affiche une erreur
        if (!isset($controller)) {
            echo 'Not found';
        }
    }
}