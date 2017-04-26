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
 * @Route("/pack")
 */
class PackController extends Controller

{

    /**
     * @Route("/test/", name="test_pack")
     */
    public function testAction(Request $request)
    {
        //$packImpl = $this->get('app.pack');
        $packImpl = new Service\PackImpl($this->getDoctrine());
        $packImpl->getAllRecipe();
        die;


        return new JsonResponse("Aucune erreur", 200, array('Response' => "ok"), true);
    }
}