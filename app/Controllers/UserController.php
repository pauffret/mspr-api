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
    $newUser->first_name = $args['firstName'];
    $newUser->last_name = $args['lastName'];
    try {
      $id = R::store($newUser);
    } catch (SQL $e) {
      $id = 0;
    }
    if ($id !== 0) {
      return $response->withJson(['data' => 'Utilisateur enregistré']);
    } else {
      return $response->withJson(['erreur' => 'Une erreur est survenue lors de l\'enregistrement de l\'utilisateur']);
    }
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

  /**
   * Renvoi un utilisateur via son ID
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function getUserById($request, $response, $args)
  {
    $user = R::load('user', $args['userId']);
    return $response->withJson(['data' => $user]);
  }

}
