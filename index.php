<?php

require('core/init.php');

$router = new Core\Router();

$router->add('', 'HomeController@index');

$router->add('famille/{num}', 'FamilleController@show');
$router->add('{num}/membre/{num}/listes', 'ListeSouhaitController@show');
$router->add('liste/{num}', 'SouhaitController@show');

$router->deal();
