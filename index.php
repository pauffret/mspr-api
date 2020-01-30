<?php

chdir(__DIR__);

require './vendor/autoload.php';


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \RedBeanPHP\R as R;


R::setup('mysql:host='.\Config\Bdd::HOST.';dbname='.\Config\Bdd::DBNAME.'',\Config\Bdd::USERNAME,\Config\Bdd::PASSWORD);
//R::setup('mysql:host=' . getenv('HOST') . ';dbname=' . getenv('DBNAME') . '', getenv('USERNAME'), getenv('PASSWORD'));

$configuration = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
];

$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

// url : http://localhost/mspr-api/index.php/users

$app->get('/users', \Controllers\UserController::class . ':getUsers');
$app->get('/promos', \Controllers\PromoController::class . ':getPromos');


$app->run();
