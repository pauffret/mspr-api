<?php


namespace Controllers;


use RedBeanPHP\R;

class UserController
{

  public function getUsers($request, $response, $args)
  {
    $users = R::getAll('SELECT * FROM user');
    return $response->withJson($users);
  }

  public function getUserById($request, $response, $args)
  {
    $user = R::getAll('SELECT * FROM user WHERE id=?', [$args['id']]);
    return $response->withJson(['data' => $user]);
  }

}
