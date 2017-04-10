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
 * @Route("/user")
 */
class UserController extends Controller

{

    /**
     * @Route("/post/", name="post_user")
     */
    public function postAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredients = $request->getContent();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->decode($ingredients, 'json');
        foreach ($data['ingredient'] as $ingredientName => $item) {
            $ingredient = $this->getDoctrine()->getRepository('AppBundle:Ingredient')->findOneBy(array('name'=>$ingredientName));
            if($ingredient === array() || is_null($ingredient)) {
                $ingredient = new Ingredient();
                $ingredient->setName($ingredientName);
                $ingredient->setUnitMesure($item['unit']);
                $ingredient->setLanguage($data['language']);
                $em->persist($ingredient);
            }
            $storage = new IngredientStorage();
            $storage->setAmount($item['amount']);
            $storage->setIngredient($ingredient);
            $storage->setUser($user);

            $em->persist($storage);
            $em->flush();

        }
        return new JsonResponse("Aucune erreur", 200, array('Response' => "ok"), true);
    }

    /**
     * @Route("/get/{id}/",requirements={"id" = "\d+"}, name="get_user")
     */
    public function getAction($id,Request $request)
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneById($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }
}