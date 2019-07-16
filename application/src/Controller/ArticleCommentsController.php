<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Comment;
use App\Exception\NotFoundException;
use App\Form\ArticleCommentType;
use App\Service\AqarmapTaskAuthenticationService;
use App\Service\ArticleCommentService;
use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\Request;

/**
 * ArticleCommentsController Class represent controller related to article comments operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleCommentsController extends AbstractAqarmapTaskController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var ArticleCommentService
     */
    private $articleCommentService;

    /**
     * @var AqarmapTaskAuthenticationService
     */
    private $aqarmapTaskAuthService;

    /**
     * ArticleCommentsController constructor.
     * @param ArticleService                   $articleService        article service instance
     * @param ArticleCommentService            $articleCommentService article comment service instance
     * @param AqarmapTaskAuthenticationService $authenticationService aqarmap task authentication service instance
     */
    public function __construct(ArticleService $articleService, ArticleCommentService $articleCommentService, AqarmapTaskAuthenticationService $authenticationService)
    {
        $this->articleService         = $articleService;
        $this->articleCommentService  = $articleCommentService;
        $this->aqarmapTaskAuthService = $authenticationService;
    }

    /**
     * Adding new comment under given article using it's id
     * @param int     $id      article's id value which want to add new comment under it
     * @param Request $request Http request instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(int $id, Request $request)
    {
        try {
            $currentLoginUser = $this->aqarmapTaskAuthService->getCurrentLoginUser();
        } catch (NotFoundException $exception) {
            return $this->redirectToRoute('home');
        }

        try {
            $article = $this->articleService->find($id);
        } catch (NotFoundException $exception) {
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

                $newComment->setCreator($currentLoginUser);
                // save new article's comment
                try {
                    $this->articleCommentService->create($newComment);
                } catch (NotFoundException $exception) {
                    return $this->redirectToRoute(
                        'article_comment_addition',
                        ['id' => $article->getId()]
                    );
                }
                // TODO: use success flush message
            }

            return $this->redirectToRoute('article_info', ['id' => $article->getId()]);
        }

        return $this->render('comment/form.html.twig', ['form' => $form->createView()]);
    }
}
