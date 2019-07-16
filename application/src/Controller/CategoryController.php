<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Category;

/**
 * CategoryController Class represent controller related to categories operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CategoryController extends AbstractAqarmapTaskController
{
    /**
     * Listing all possible categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }
}
