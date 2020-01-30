<?php


namespace Controllers;


use RedBeanPHP\R;

class PromoController
{

    public function getPromos($request, $response, $args){
        $promo = R::getAll('SELECT * FROM promo');
        return $response->withJson($promo);
    }

}
