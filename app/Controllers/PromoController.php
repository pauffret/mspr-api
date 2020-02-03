<?php


namespace Controllers;


use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class PromoController
{

  /**
   * Permet de check le code réduc' après un scan et de l'ajouter à l'utilisateur si il ne le possède pas déjà
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function scanReduc($request, $response, $args)
  {
    //Check si le code existe
    $reduc = R::find('promo', 'code = ' . $args['code']);
    if ($reduc) {
      //Check si la reduc est dispo
      if ($reduc['end_date'] <= date('Y-m-d')) {
        //Check si le user possède déjà ce code dans sa liste
        $userPromo = R::find('user_promo', 'user_id = ' . $args['userId'] . ' AND promo_id = ' . $reduc['id']);
        if ($userPromo) {
          return $response->withJson(['error' => 'Vous avez déjà scanné ce code de réduction']);
        } else {
          $newUserPromo = R::dispense('user_promo');
          $newUserPromo->user_id = $args['userId'];
          $newUserPromo->promo_id = $reduc['id'];
          try {
            $id = R::store($newUserPromo);
            return $response->withJson(['data' => 'Le code a bien été ajouté à votre liste de réduction']);
          } catch (SQL $e) {
            return $response->withJson(['error' => 'Une erreur est survenue lors de l\'ajout du code à la liste des réductions']);
          }
        }
      } else {
        return $response->withJson(['error' => 'Ce code promo n\'est plus disponible']);
      }
    } else {
      return $response->withJson(['error' => 'Ce code promo n\'existe pas']);
    }
  }

  /**
   * Renvoi la liste de tous les codes réductions de l'utilisateur choisi
   * @param $request
   * @param $response
   * @param $args
   * @return mixed
   */
  public static function listReduc($request, $response, $args)
  {
    $userPromos = R::getCol('SELECT promo_id FROM user_promo WHERE user_id = ' . $args['userId']);
    $listPromos = [];
    foreach ($userPromos as $userPromoId) {
      $promo = R::load('promo', $userPromoId);
      array_push($listPromos, $promo);
    }
    return $response->withJson(['data' => $listPromos]);
  }

}
