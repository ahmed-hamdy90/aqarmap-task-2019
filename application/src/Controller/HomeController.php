<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Article;
use App\Entity\Category;

/**
 * HomeController Class represent controller as index page for aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class HomeController extends AbstractAqarmapTaskController
{
    /**
     * home action for aqarmap task application
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['publishedAt' => 'DESC'], 5);

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy([], [], 5);

        return $this->render(
            'home/index.html.twig',
            ['articles' => $articles, 'categories' => $categories]
        );
    }
}
