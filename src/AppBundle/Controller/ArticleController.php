<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
        $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($articles, 'json');
        return new JsonResponse($jsonContent, 200, array('bob'=>1), true);
    }

    /**
     * @Route(
     *     "/{id}",
     *     requirements={"id" = "\d+"},
     *     name="article_show"
     * )
     */
    public function showAction(Article $article)
    {
        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/admin/add", name="article_add")
     */
    public function addAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('image.uploader')->upload($article);

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'The article was successfully saved in database!');

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/add.html.twig', ['articleForm' => $form->createView()]);
    }

    /**
     * @Route(
     *     "/admin/update/{id}",
     *     name="article_update",
     *     requirements={"id" = "\d+"}
     * )
     */
    public function updateAction(Request $request, Article $article)
    {
        $articleImgPath = $article->getHeaderImage();
        if (null != $articleImgPath) {
            $article->setHeaderImage(
                new File($this->getParameter('file_path').$articleImgPath)
            );
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('image.uploader')->upload($article);
            if(!$article->getHeaderImage()) {
                $article->setHeaderImage($articleImgPath);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'The article was successfully updated in database!');

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/add.html.twig', [
            'articleForm' => $form->createView(),
            'article' => $article,
            'oldArticleImage' => $articleImgPath
        ]);
    }
}