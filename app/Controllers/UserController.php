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
    //Check si l'e-mail est déjà utilisé
//    $alreadyUse = R::find('user', 'mail = ' . $args['mail']);
    $alreadyUse = R::getRow('SELECT * FROM user WHERE mail = :mail', [
      ':mail' => $args['mail']
    ]);
    if ($alreadyUse) {
      //Ajoute l'utilisateur si l'e-mail n'est pas déjà utilisé
      $newUser = R::dispense('user');
      $newUser->mail = $args['mail'];
      $newUser->password = $args['password'];
      $newUser->first_name = $args['firstName'];
      $newUser->last_name = $args['lastName'];
      try {
        $id = R::store($newUser);
//        R::exec('INSERT INTO user VALUES(0, ' . $args['mail'] . ', ' . $args['password'] . ', ' . $args['firstName'] . ', ' . $args['lastName'] . ')');
//        $id = R::getInsertID();
      } catch (SQL $e) {
        $id = 0;
      }
      if ($id !== 0) {
        return $response->withJson(['data' => 'Utilisateur enregistré']);
      } else {
        return $response->withJson(['error' => 'Une erreur est survenue lors de l\'enregistrement de l\'utilisateur']);
      }
    } else {
      return $response->withJson(['error' => 'Un compte avec cette adresse e-mail existe déjà']);
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
      return $response->withJson(['error' => 'Login ou mot de passe incorrect.']);
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
