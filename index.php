<?php

chdir(__DIR__);

require './vendor/autoload.php';


use Config\Bdd;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \RedBeanPHP\R as R;


R::setup('mysql:host=' . Bdd::HOST . ';dbname=' . Bdd::DBNAME . '', Bdd::USERNAME, Bdd::PASSWORD);

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
