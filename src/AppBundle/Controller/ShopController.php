<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:48
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Pack;
use AppBundle\Entity\ShopTransaction;
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
 * @Route("/shop")
 */
class ShopController extends Controller

{

    /**
     * @Route("/buy/{userId}/{packId}/", name="buy_pack")
     */
    public function buyAction($userId, $packId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneById($userId);
        $pack = $this->getDoctrine()->getRepository('AppBundle:Pack')->findOneById($packId);

        $transaction = new ShopTransaction();
        $transaction->setUser($user);
        $transaction->setPack($pack);

        $em->persist($transaction);
        $em->flush();


        return new JsonResponse("Aucune erreur", 200, array('Response' => "ok"), true);
    }

    /**
     * @Route("/get/{id}/",requirements={"id" = "\d+"}, name="get_pack")
     */
    public function getAction($id,Request $request)
    {
        /** @var Pack $pack */
        $pack = $this->getDoctrine()->getRepository('AppBundle:Pack')->findOneById($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($pack, 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }

    /**
     * @Route("/get/", name="get_all_pack")
     */
    public function getAllAction(Request $request)
    {
        /** @var Pack $pack */
        $pack = $this->getDoctrine()->getRepository('AppBundle:Pack')->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($pack, 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }
}