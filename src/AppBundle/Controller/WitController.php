<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 27/03/2017
 * Time: 11:48
 */

namespace AppBundle\Controller;

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
 * @Route("/wit")
 */
class WitController extends Controller

{

    /**
     * @Route("/", name="wit_homepage")
     */
    public function homepageAction(Request $request)
    {
        $witImpl = $this->get('app.wit');
        $message = $request->query->get('message');
        $language = $request->query->get('language');
        if($message === null || $message === ""){
            return new JsonResponse(array(), 400, array('Response'=>"ko"), false);
        }
        if($language === null ||$language===""){
            $language = 'EN';
        }
        $data = $witImpl->connect($language, $message);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($data['entities'], 'json');
        if ($jsonContent === array()){
            return new JsonResponse($jsonContent, 400, array('Response'=>"ko"), false);
        }else {
            return new JsonResponse($jsonContent, 200, array('Response' => "ok"), true);
        }
    }
}