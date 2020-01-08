<?php


namespace Controllers;


use RedBeanPHP\R;

class Ingredient
{

    public static function getIngredients($request, $response, $args){
        $ingredient = R::getAll('SELECT * FROM ingredient');
        return $response->withJson($ingredient);
    }

}