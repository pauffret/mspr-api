<?php

chdir(__DIR__);

require './vendor/autoload.php';


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \RedBeanPHP\R as R;


//R::setup('mysql:host='.\Config\Bdd::HOST.';dbname='.\Config\Bdd::DBNAME.'',\Config\Bdd::USERNAME,\Config\Bdd::PASSWORD);
R::setup('mysql:host=' . getenv('HOST') . ';dbname=' . getenv('DBNAME') . '', getenv('USERNAME'), getenv('PASSWORD'));


$configuration = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
];

$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

// url : http://localhost/apitise-cocktail/index.php/cocktails

$app->get('/cocktails', \Controllers\Cocktail::class . ':getCocktails');
$app->get('/ingredients', \Controllers\Ingredient::class . ':getIngredients');


$app->run();
