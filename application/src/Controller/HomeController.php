<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Service\ArticleService;
use App\Service\CategoryService;
use App\Service\Interfaces\ActiveRecordInterface;

/**
 * HomeController Class represent controller as index page for aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class HomeController extends AbstractAqarmapTaskController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * HomeController constructor.
     * @param CategoryService $categoryService category service instance
     * @param ArticleService  $articleService  article service instance
     */
    public function __construct(CategoryService $categoryService, ArticleService $articleService)
    {
        $this->categoryService = $categoryService;
        $this->articleService  = $articleService;
    }

    /**
     * home action for aqarmap task application
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $articles = $this->articleService
            ->findByCriteria([], 5, 0,ActiveRecordInterface::DESC, 'publishedAt');

        $categories = $categories = $this->categoryService->findByCriteria([], 5);

        return $this->render(
            'home/index.html.twig',
            ['articles' => $articles, 'categories' => $categories]
        );
    }
}
