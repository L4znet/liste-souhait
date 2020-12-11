<?php

namespace Core;

class View 
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function render($data = [])
    {
        extract($data);

        $message = unflash('message');
        $data = unflash('data', []);
        $errors = unflash('errors', []);

        require('views/' . $this->template . '.php');
    }
}