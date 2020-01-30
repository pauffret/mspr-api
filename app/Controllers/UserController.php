<?php


namespace Controllers;


use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class UserController
{

  /**
   * Permet l'insertion d'un nouvel utilisateur en BDD
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function insertUser($request, $response, $args)
  {
    $newUser = R::dispense('user');
    $newUser->mail = $args['mail'];
    $newUser->password = $args['password'];
    $newUser->firstName = $args['firstName'];
    $newUser->lastName = $args['lastName'];
    try {
      $id = R::store($newUser);
    } catch (SQL $e) {
      $id = 0;
    }
//    $newUser = R::exec('INSERT INTO user VALUES(0, :mail, :password, :firstName, :lastName)', [
//      ':mail' => $args['mail'],
//      ':password' => $args['password'],
//      ':firstName' => $args['firstName'],
//      ':lastName' => $args['lastName']
//    ]);
    if ($id !== 0) {
      return $response->withJson(['data' => $newUser]);
    } else {
      return $response->withJson(['data' => 'Login ou mot de passe incorrect.']);
    }
  }

  /**
   * Récupération d'un utilisateur en fonction d'un id donné
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function getUserById($request, $response, $args)
  {
//    $user = R::getAll('SELECT * FROM user WHERE id=?', [$args['id']]);
    $user = R::load('user', $args['id']);
    return $response->withJson(['data' => $user]);
  }

  /**
   * Vérification des infos de connexion de l'utilisateur à la connexion
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function tryUserConnection($request, $response, $args)
  {
    $user = R::getRow('SELECT * FROM user WHERE mail= :mail AND password= :password', [
      ':mail' => $args['mail'],
      ':password' => $args['password']
    ]);
    if ($user) {
      return $response->withJson(['data' => $user]);
    } else {
      return $response->withJson(['data' => 'Login ou mot de passe incorrect.']);
    }
  }

}
