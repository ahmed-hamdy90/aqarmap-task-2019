<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * ArticleController Class represent controller related to articles operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleController extends AbstractAqarmapTaskController
{
    /**
     * Listing all possible articles, or all possible belong to specific category
     * @param Request $request Htttp request instance
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request)
    {
        $categoryId = $request->query->get('category', null);

        $articleRepository = $this->getDoctrine()
            ->getRepository(Article::class);
        if ($categoryId) {
            $articles = $articleRepository->getArticlesFilteredByCategory($categoryId);
        } else {
            $articles = $articleRepository->findBy([], ['publishedAt' => 'DESC']);
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
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        // check if given article already exists or not
        if (!$article) {
            throw $this->createNotFoundException("Article not found");
        }

        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    /**
     * Add new article operation
     * @param Request          $request Htttp request instance
     * @param SessionInterface $session Session instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, SessionInterface $session)
    {
        $currentLoginUser =
            $session->get(AuthenticationController::LOGIN_USER_SESSION_KEY, null);
        if (!is_null($currentLoginUser) && is_array($currentLoginUser)) {
            $currentLoginUser = $currentLoginUser[0];
        }
        // must there be current login user plus must be admin role
        if (!($currentLoginUser instanceof User) || $currentLoginUser->getRole() !== User::ADMIN_ROLE) {
            return $this->redirectToRoute('home');
        }

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

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

                $author = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($currentLoginUser->getId());

                $newArticle->setAuthor($author);
                // save new article
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newArticle);
                $entityManager->flush();

                // TODO: use success flush message
                return $this->redirectToRoute('article_info', ['id' => $newArticle->getId()]);
            }

            return $this->redirectToRoute('article_addition');
        }

        return $this->render('article/form.html.twig', ['form' => $form->createView()]);
    }
}