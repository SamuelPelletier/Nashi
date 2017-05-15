<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:48
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\IngredientStorage;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/recipe")
 */
class RecipeController extends Controller

{

    /**
     * @Route("/{id}/", requirements={"id" = "\d+"},name="get_recipe")
     */
    public function getAction($id,Request $request)
    {
        /** @var Recipe $recipe */
        $recipeObj = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findOneById($id);
        /** @var Ingredient $ingredients */
        $ingredients = $this->getDoctrine()->getRepository('AppBundle:RecipeIngredient')->findBy(array('recipe'=>$recipeObj));
        $steps = $this->getDoctrine()->getRepository('AppBundle:RecipeStep')->findBy(array('recipe'=>$recipeObj));
        $recipe['data'] = $recipeObj;
        $recipe['ingredient'] = $ingredients;
        $stepsConvert = array();
        foreach ($steps as $step) {
            $stepsConvert[$step->getRang()] = $step->getStep()->getDescription();
        }
        $recipe['step'] = $stepsConvert;
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($recipe, 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }

    /**
     * @Route("/{name}/",name="get_recipe_name")
     */
    public function getByNameAction($name,Request $request)
    {
        /** @var Recipe $recipe */
        $recipeObj = $this->getDoctrine()->getRepository('AppBundle:Recipe')->getRecipeByName($name);
        /** @var Ingredient $ingredients */
        $ingredients = $this->getDoctrine()->getRepository('AppBundle:RecipeIngredient')->findBy(array('recipe'=>$recipeObj));
        $steps = $this->getDoctrine()->getRepository('AppBundle:RecipeStep')->findBy(array('recipe'=>$recipeObj));
        $recipe['data'] = $recipeObj;
        $recipe['ingredient'] = $ingredients;
        $stepsConvert = array();
        foreach ($steps as $step) {
            $stepsConvert[$step->getRang()] = $step->getStep()->getDescription();
        }
        $recipe['step'] = $stepsConvert;
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($recipe, 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }
}