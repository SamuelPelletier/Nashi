<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:55
 */
use AppBundle\Entity\Recipe;
use Tgallice\Wit\Client;
use Tgallice\Wit\MessageApi;

class PackImpl
{
    protected $doctrine;

    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }

    public function getTotalRecipe()
    {
        $data = $this->makeRequest();
        return $data['totalMatchCount'];
    }

    public function getAllRecipe()
    {
        $em = $this->doctrine->getManager();
        $recipes = $this->doctrine->getRepository('AppBundle:Recipe')->findAll();
        $nbrRecipe = count($recipes);
        $maxResult = $this->getTotalRecipe();
        if($maxResult > $nbrRecipe) {
            // tranche de 1000
            $data = $this->makeRequest(array('maxResult' => 1000));
            dump($maxResult);
            die;
            foreach ($data as $item) {
                $exist = false;
                foreach ($recipes as $recipe){
                    if($item['id'] === $recipe->getRecipeId()){
                        $exist =true;
                    }
                }
                if($exist === false){
                    $newRecipe = new Recipe();
                    $newRecipe->setIdRecipe($item['id']);
                    $newRecipe->setType(null);
                    $em->persist($newRecipe);
                    $em->flush();
                }
            }
        }

    }

    private function makeRequest($param = null){
        $url = "http://api.yummly.com/v1/api/recipes?_app_id=2145c78a&_app_key=018b9abf9f3a796911b4209cb1fa83b4";
        if($param !== null) {
            foreach ($param as $key => $item) {
                $url .= '&' . $key . '=' . $item;
            }
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        return $data;
    }

}