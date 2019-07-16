<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\User;
use App\Exception\AuthenticationFailedException;
use App\Exception\NotFoundException;
use App\Form\LoginType;
use App\Service\AqarmapTaskAuthenticationService;
use Symfony\Component\HttpFoundation\Request;

/**
 * AuthenticationController Class represent controller related to authentication operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class AuthenticationController extends AbstractAqarmapTaskController
{
    /**
     * @var AqarmapTaskAuthenticationService
     */
    private $aqarmapTaskAuthService;

    /**
     * AuthenticationController constructor.
     * @param AqarmapTaskAuthenticationService $authenticationService aqarmap task authentication service instance
     */
    public function __construct(AqarmapTaskAuthenticationService $authenticationService)
    {
        $this->aqarmapTaskAuthService = $authenticationService;
    }

    /**
     * Login operation
     * @param Request $request  Http request instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {

        try {
            $this->aqarmapTaskAuthService->getCurrentLoginUser();
        } catch (NotFoundException $exception) {
            $user = new User();

            $form = $this->createForm(LoginType::class, $user);
            // according to request's method (POST as submit and default GET as view form)
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    /** @var User $user */
                    $user = $form->getData();

                    try {
                        $this->aqarmapTaskAuthService->login($user->getUsername(), $user->getPassword());
                    } catch (AuthenticationFailedException $exception) {
                        // TODO: use error flush message
                        return $this->redirectToRoute('user_login');
                    }

                    // TODO: use success flush message
                    return $this->redirectToRoute('home');
                }

                return $this->redirectToRoute('user_login');
            }

            return $this->render('authentication/login.html.twig', ['form' => $form->createView()]);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * Logout operation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout()
    {
        $this->aqarmapTaskAuthService->logout();

        return $this->redirectToRoute('home');
    }
}