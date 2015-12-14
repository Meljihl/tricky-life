<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

//        $article = new Article();
//        $article->setDescription("Quand vous marchez dans la rue, regardez par terre");
//        $article->setName("Astuce dans la rue");
//        $em->persist($article);
//        $em->flush();

        $repository = $em->getRepository('AppBundle:Article');
        $articleList = $repository->findAll();

        return $this->render(
            'default/index.html.twig',
            array('articleList' => $articleList)
        );
    }
}
