<?php

namespace AppBundle\Controller;

use AppBundle\DTO\ArticleDTO;

use AppBundle\DTO\CommentDTO;
use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleVotes;
use AppBundle\Entity\Comment;
use AppBundle\Entity\CommentVotes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Category');
        $categoriesList = $repository->findAll();

        $repository = $em->getRepository('AppBundle:Article');
        $articleList = $repository->findBy(array(), array('id' => 'DESC'));

        $articlesDTOList = array();

        foreach ($articleList as $article) {
            // On récupère la liste des commentaires de cet article
            $commentsList = $em->getRepository('AppBundle:Comment')
                ->findBy(array('article' => $article));

            $votesList = $em->getRepository('AppBundle:ArticleVotes')
                ->findBy(array('article' => $article));

            $articleDTO = new ArticleDTO();
            $articleDTO->bind($article, count($commentsList), $votesList);

            array_push($articlesDTOList, $articleDTO);
        }

        return $this->render(
            'default/index.html.twig',
            array('articleList' => $articlesDTOList,
                'categoriesLists' => $categoriesList,
                'selectedItem' => 'home')
        );
    }

    /**
     * @Route("/add", name="addArticle")
     */
    public function addArticleAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category');
        $categoriesList = $repository->findAll();

        return $this->render(
            'default/add_article.html.twig',
             array('categoriesLists' => $categoriesList)
        );
    }

    /**
     * @Route("/useraccount", name="showUserAccount")
     */
    public function userAccountAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        // On récupère la liste des commentaires de cet article
        $articlesList = $em->getRepository('AppBundle:Article')
            ->findBy(array('user' => $this->getUser()));

        $articlesDTOList = array();
        foreach ($articlesList as $article) {
            // On récupère la liste des commentaires de cet article
            $commentsList = $em->getRepository('AppBundle:Comment')
                ->findBy(array('article' => $article));

            $votesList = $em->getRepository('AppBundle:ArticleVotes')
                ->findBy(array('article' => $article));

            $articleDTO = new ArticleDTO();
            $articleDTO->bind($article, count($commentsList), $votesList);

            array_push($articlesDTOList, $articleDTO);
        }


        return $this->render(
            'default/user_account.html.twig',
            array('user' => $this->getUser(),
                  'articles' => $articlesDTOList)
        );
    }

    /**
     * @Route("/new", name="newArticle")
     */
    public function newArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Category')
            ->find($request->request->get('category'));


        $article = new Article();
        $article->description = ($request->request->get('description'));
        $article->name = ($request->request->get('title'));
        $article->category = $category;
        $article->user = $this->getUser();

        $em->persist($article);
        $em->flush();

        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/details/{articleId}", name="details")
     */
    public function articleDetailsAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();

        //Récupération de l'article
        $article = $em->getRepository('AppBundle:Article')->find($articleId);

        // On récupère la liste des commentaires de cet article
        $commentsList = $em->getRepository('AppBundle:Comment')
            ->findBy(array('article' => $article));

        $votesList = $em->getRepository('AppBundle:ArticleVotes')
            ->findBy(array('article' => $article));

        $articleDTO = new ArticleDTO();
        $articleDTO->bind($article, count($commentsList), $votesList);

        $commentsDTO = array();
        foreach($commentsList as $comment) {
            $commentVotes = $em->getRepository('AppBundle:CommentVotes')
                ->findBy(array('comment' => $comment));

            $commentDTO = new CommentDTO();
            $commentDTO->bind($comment, $commentVotes);

            array_push($commentsDTO, $commentDTO);
        }

        return $this->render(
            'default/details.html.twig',
            array('article' => $articleDTO,
                  'commentsList' => $commentsDTO)
        );
    }

    /**
     * @Route("/details/{articleId}/delete", name="deleteArticle")
     */
    public function deleteArticleAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();

        //Récupération de l'article
        $article = $em->getRepository('AppBundle:Article')->find($articleId);

        $em->remove($article);

        $em->flush();

        return new Response();
    }

    /**
     * @Route("/details/{articleId}/thumbsup", name="thumbsUpArticle")
     */
    public function thumbsUpArticleAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();

        $votes = new ArticleVotes();

        $votes->user = $em->getRepository('AppBundle:User')->find($this->getUser());
        $votes->article = $em->getRepository('AppBundle:Article')->find($articleId);
        $votes->type = 'Up';

        $em->persist($votes);

        $em->flush();

        return new Response();
    }

    /**
     * @Route("/details/{articleId}/thumbsdown", name="thumbsDownArticle")
     */
    public function thumbsDownArticleAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();


        $votes = new ArticleVotes();
        $votes->user = $em->getRepository('AppBundle:User')->find($this->getUser());
        $votes->article = $em->getRepository('AppBundle:Article')->find($articleId);
        $votes->type = 'Down';

        $em->persist($votes);

        $em->flush();

        return new Response();
    }

    /**
     * @Route("/details/{articleId}/addComment", name="addComment")
     */
    public function addCommentAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($articleId);

        return $this->render(
            'default/add_comment.html.twig',array('article' => $article)
        );
    }

    /**
     * @Route("/details/{articleId}/createComment", name="createComment")
     */
    public function createCommentAction(Request $request, $articleId) {
        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $comment->description = ($request->request->get('description'));
        $comment->name = ($request->request->get('title'));
        $comment->user = $this->getUser();
        $comment->article = $em->getRepository('AppBundle:Article')->find($articleId);

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute("details", array('articleId' => $articleId ));
    }

    /**
     * @Route("/comment/{commentId}/thumbsdown", name="thumbsDownComment")
     */
    public function thumbsDownCommentAction(Request $request, $commentId) {
        $em = $this->getDoctrine()->getManager();


        $votes = new CommentVotes();
        $votes->user = $em->getRepository('AppBundle:User')->find($this->getUser());
        $votes->comment = $em->getRepository('AppBundle:Comment')->find($commentId);
        $votes->type = 'Down';

        $em->persist($votes);

        $em->flush();

        return new Response();
    }

    /**
     * @Route("/comment/{commentId}/thumbsup", name="thumbsUpComment")
     */
    public function thumbsUpCommentAction(Request $request, $commentId) {
        $em = $this->getDoctrine()->getManager();


        $votes = new CommentVotes();
        $votes->user = $em->getRepository('AppBundle:User')->find($this->getUser());
        $votes->comment = $em->getRepository('AppBundle:Comment')->find($commentId);
        $votes->type = 'Up';

        $em->persist($votes);

        $em->flush();

        return new Response();
    }

}
