<?php

require('core/init.php');

$router = new Core\Router();

$router->add('', 'HomeController@index');

$router->add('famille/{num}', 'FamilleController@show');
$router->add('famille/create', 'FamilleController@create');
$router->add('famille/store', 'FamilleController@store', true);
$router->add('famille/{num}/edit', 'FamilleController@edit');
$router->add('famille/{num}/update', 'FamilleController@update', true);
$router->add('famille/{num}/destroy', 'FamilleController@destroy');

$router->add('famille/{num}/membre/create', 'MembreController@create');
$router->add('famille/{num}/membre/store', 'MembreController@store', true);
$router->add('membre/{num}/edit', 'MembreController@edit');
$router->add('membre/{num}/update', 'MembreController@update', true);
$router->add('membre/{num}/destroy', 'MembreController@destroy');

$router->add('membre/{num}/listes', 'ListeSouhaitController@show');
$router->add('membre/{num}/listes/create', 'ListeSouhaitController@create');
$router->add('membre/{num}/listes/store', 'ListeSouhaitController@store', true);
$router->add('liste/{num}/edit', 'ListeSouhaitController@edit');
$router->add('liste/{num}/update', 'ListeSouhaitController@update', true);
$router->add('liste/{num}/destroy', 'ListeSouhaitController@destroy');

$router->add('liste/{num}/souhait', 'SouhaitController@show');
$router->add('liste/{num}/souhait/create', 'SouhaitController@create');
$router->add('liste/{num}/souhait/store', 'SouhaitController@store', true);
$router->add('souhait/{num}/edit', 'SouhaitController@edit');
$router->add('souhait/{num}/update', 'SouhaitController@update', true);
$router->add('souhait/{num}/destroy', 'SouhaitController@destroy');


$router->deal();
