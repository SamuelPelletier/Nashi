<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_homepage")
     */
    public function homepageAction()
    {
        return $this->render('article/index.html.twig');
    }

    /**
     * @Route(
     *     "/{id}",
     *     requirements={"id" = "\d+"},
     *     defaults={"id" = 1},
     *     name="article_show"
     * )
     */
    public function showAction()
    {
        return $this->render('article/show.html.twig');
    }

    /**
     * @Route("/add", name="article_add")
     */
    public function addAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'The article was successfully saved in database!');

            return $this->redirectToRoute('article_homepage');
        }

        return $this->render('article/add.html.twig', ['articleForm' => $form->createView()]);
    }

    /**
     * @Route(
     *     "/update/{id}",
     *     name="article_update",
     *     requirements={"id" = "\d+"}
     * )
     */
    public function updateAction(Article $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'The article was successfully updated in database!');

            return $this->redirectToRoute('article_homepage');
        }

        return $this->render('article/add.html.twig', [
            'articleForm' => $form->createView(),
            'article' => $article,
        ]);
    }
}