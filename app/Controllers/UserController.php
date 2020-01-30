<?php


namespace Controllers;


use RedBeanPHP\R;

class UserController
{

  public static function getUsers($request, $response, $args)
  {
    $users = R::getAll('SELECT * FROM user');
    return $response->withJson($users);
  }

}
