<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Article;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Form\ArticleType;
use App\Service\AqarmapTaskAuthenticationService;
use App\Service\ArticleService;
use App\Service\CategoryService;
use App\Service\Interfaces\ActiveRecordInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * ArticleController Class represent controller related to articles operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleController extends AbstractAqarmapTaskController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var AqarmapTaskAuthenticationService
     */
    private $aqarmapTaskAuthService;

    /**
     * ArticleController constructor.
     * @param ArticleService                   $articleService        article service instance
     * @param CategoryService                  $categoryService       category service instance
     * @param AqarmapTaskAuthenticationService $authenticationService aqarmap task authentication service instance
     */
    public function __construct(ArticleService $articleService, CategoryService $categoryService, AqarmapTaskAuthenticationService $authenticationService)
    {
        $this->articleService         = $articleService;
        $this->categoryService        = $categoryService;
        $this->aqarmapTaskAuthService = $authenticationService;
    }

    /**
     * Listing all possible articles, or all possible belong to specific category
     * @param Request $request Htttp request instance
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request)
    {
        $categoryId = $request->query->get('category', null);

        if ($categoryId) {
            $articles = $this->articleService->findByCategoryId($categoryId);
        } else {
            $articles = $this->articleService
                    ->findByCriteria(
                        [],
                        ActiveRecordInterface::DEFAULT_COUNTER,
                        0,
                        ActiveRecordInterface::DESC,
                        'publishedAt'
                    );
        }

        return $this->render('article/list.html.twig', ['articles' => $articles]);
    }

    /**
     * Display article's details using given it's id
     * @param int $id article's id value
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(int $id)
    {
        try {
            $article = $this->articleService->find($id);
        } catch (NotFoundException $exception) {
            throw $this->createNotFoundException("Article not found");
        }

        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    /**
     * Add new article operation
     * @param Request $request Htttp request instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        try {
            $currentLoginUser = $this->aqarmapTaskAuthService->getCurrentLoginUser();
        } catch (NotFoundException $exception) {
            return $this->redirectToRoute('home');
        }
        // must current login user has admin role
        if ($currentLoginUser->getRole() !== User::ADMIN_ROLE) {
            return $this->redirectToRoute('home');
        }

        $categories = $this->categoryService->findByCriteria([]);

        $newArticle = new Article();

        $form = $this->createForm(
            ArticleType::class,
            $newArticle,
            [
                'categoriesOptions' => $categories
            ]
        );
        // according to request's method (POST as submit and default GET as view form)
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Article $newArticle */
                $newArticle = $form->getData();

                $newArticle->setAuthor($currentLoginUser);
                // save new article
                try {
                    $this->articleService->create($newArticle);
                } catch (NotFoundException $exception) {
                    return $this->redirectToRoute('article_addition');
                }

                // TODO: use success flush message
                return $this->redirectToRoute('article_info', ['id' => $newArticle->getId()]);
            }

            return $this->redirectToRoute('article_addition');
        }

        return $this->render('article/form.html.twig', ['form' => $form->createView()]);
    }
}