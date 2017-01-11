<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        /* return new Response(
         *   'Hello',
         *    Response::HTTP_INTERNAL_SERVER_ERROR,
         *    ['X-My-Header' => "Youhou j'ai fait mon propre header"]
         * );
         */

        return new Response(
            $this->renderView('exercise/exercise.html.twig'),
            Response::HTTP_OK,
            ['X-My-Header' => "Youhou j'ai fait mon propre header"]
        );
    }
}
