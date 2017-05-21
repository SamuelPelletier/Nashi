<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:55
 */

class WeCookImpl
{
    public function callWecook($id = null, $ingredient = null,$with_is = null,$page = null)
    {
// $url will contain the API endpoint
        $url = "https://www.wecook.fr/web-api/";

        if($id !== null){
            $url.= 'recipes?id='.$id;
        }else if($ingredient !== null){
            $url .= 'resources/autocomplete?q='.$ingredient.'&type=ingredient';
        }else if($with_is !== null){
            $url.= 'recipes/search?with_is=['.$with_is.']';
        }else if($page !== null){
            $url.= 'recipes/search?page='.$page;
        }else{
            $url.= 'recipes/search';
        }

// Make the POST request using Curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer qFS9q2cQ4h4ijNQVBRihvQ", "Wecook-Version: 1"));

// Decode and display the output
        $api_output = curl_exec($ch);
        $json_output = json_decode($api_output, true);
        $output = $json_output ? $json_output : $api_output;
// Clean up
        curl_close($ch);

// Get the decoded body
        return $output;
    }

    public function getRecipeWithIngredient($ingredient){
        $result = $this->callWecook(null, $ingredient);
        $ingredientRecipes = array();
        foreach ($result['result']['ingredient'] as $key => $item) {
            $recipes = $this->callWecook(null, null, $item['entity_id']);
            $ingredientRecipes[$item['name']] = $recipes['result']['resources'];
        }
        return $ingredientRecipes;
    }

}