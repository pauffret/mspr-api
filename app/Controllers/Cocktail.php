<?php


namespace Controllers;


use RedBeanPHP\R;

class Cocktail
{

    public static function getCocktails($request, $response, $args){
        $cocktail = R::getAll('SELECT * FROM cocktail');
        return $response->withJson($cocktail);
    }

}