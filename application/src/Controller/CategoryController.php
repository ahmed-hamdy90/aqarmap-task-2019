<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Service\CategoryService;

/**
 * CategoryController Class represent controller related to categories operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CategoryController extends AbstractAqarmapTaskController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService category service instance
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Listing all possible categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list()
    {
        $categories = $this->categoryService->findByCriteria([]);

        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }
}
