<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleCommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * ArticleCommentsController Class represent controller related to article comments operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleCommentsController extends AbstractAqarmapTaskController
{
    /**
     * Adding new comment under given article using it's id
     * @param int              $id      article's id value which want to add new comment under it
     * @param Request          $request Http request instance
     * @param SessionInterface $session Session instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(int $id, Request $request, SessionInterface $session)
    {
        $currentLoginUser =
            $session->get(AuthenticationController::LOGIN_USER_SESSION_KEY, null);
        if (!is_null($currentLoginUser) && is_array($currentLoginUser)) {
            $currentLoginUser = $currentLoginUser[0];
        }
        // must there be current login user
        if (!($currentLoginUser instanceof User)) {
            return $this->redirectToRoute('home');
        }

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        // check if given article already exists or not
        if (!$article) {
            throw $this->createNotFoundException("Article not found");
        }

        $newComment = new Comment();
        $newComment->setArticle($article);

        $form = $this->createForm(ArticleCommentType::class, $newComment);

        // according to request's method (POST as submit and default GET as view form)
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Comment $newComment */
                $newComment = $form->getData();

                $creator = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($currentLoginUser->getId());

                $newComment->setCreator($creator);
                // save new article's comment
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newComment);
                $entityManager->flush();

                // TODO: use success flush message
            }

            return $this->redirectToRoute('article_info', ['id' => $article->getId()]);
        }

        return $this->render('comment/form.html.twig', ['form' => $form->createView()]);
    }
}
