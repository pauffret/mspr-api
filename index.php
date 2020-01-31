<?php

chdir(__DIR__);

require './vendor/autoload.php';


use Config\Bdd;
use RedBeanPHP\R as R;


R::setup('mysql:host=' . Bdd::HOST . ';dbname=' . Bdd::DBNAME, Bdd::USERNAME, Bdd::PASSWORD);

$configuration = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
];

$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

// url : http://localhost/mspr-api/index.php/users

$app->get('/insert_user/{mail}/{password}/{firstName}/{lastName}', \Controllers\UserController::class . ':insertUser');
$app->get('/getUserById/{userId}', \Controllers\UserController::class . ':getUserById');
$app->get('/connect_user/{mail}/{password}', \Controllers\UserController::class . ':tryUserConnection');
$app->get('/scan_reduc/{userId}/{code}', \Controllers\PromoController::class . ':scanReduc');
$app->get('/list_reducs/{userId}', \Controllers\PromoController::class . ':listReduc');

$app->run();
