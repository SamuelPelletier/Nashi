<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:48
 */

namespace AppBundle\Controller;

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
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $request->getContent();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->decode($user, 'json');
        $userBDD = new User();
        $userBDD->setEmail($data['email']);
        $userBDD->setGoogleToken($data['token']);

        $em->persist($userBDD);
        $em->flush();


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

    /**
     * @Route("/google/{token}/", name="get_google_user")
     */
    public function getGoogleAction($token,Request $request)
    {
        $clientGoogle = $this->get('app.google');
        $user = $clientGoogle->getUser($token);

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