<?php

namespace App\Controller;

use App\Controller\Abstracts\AbstractAqarmapTaskController;
use App\Entity\User;
use App\Form\LoginType;
use App\Utils\EncryptUserPassword;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * AuthenticationController Class represent controller related to authentication operation under aqarmap task application
 * @package App\Controller
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class AuthenticationController extends AbstractAqarmapTaskController
{
    /**
     * @const AuthenticationController::LOGIN_USER_SESSION_KEY represent session key of saved login user instance
     */
    const LOGIN_USER_SESSION_KEY = 'login-user';

    /**
     * Login operation
     * @param Request          $request  Http request instance
     * @param SessionInterface $session  Session instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, SessionInterface $session)
    {
        // check first if user already login or not
        $currentLoginUser =
            $session->get(AuthenticationController::LOGIN_USER_SESSION_KEY, null);
        if (is_null($currentLoginUser)) {
            $user = new User();

            $form = $this->createForm(LoginType::class, $user);
            // according to request's method (POST as submit and default GET as view form)
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    /** @var User $user */
                    $user = $form->getData();

                    // check if user already exists or not
                    $loginUser = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findBy([
                            'username' => $user->getUsername(),
                            'password' => (new EncryptUserPassword($user->getPassword()))->encrypt()
                        ]);

                    if (!$loginUser) {
                        return $this->redirectToRoute('user_login');
                    }
                    // save on session
                    $session->set(AuthenticationController::LOGIN_USER_SESSION_KEY, $loginUser);
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
     * @param SessionInterface $session Session instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout(SessionInterface $session)
    {
        // check first if user already login or not
        $currentLoginUser =
            $session->get(AuthenticationController::LOGIN_USER_SESSION_KEY, null);
        if (!is_null($currentLoginUser)) {
            $session->remove(AuthenticationController::LOGIN_USER_SESSION_KEY);
        }

        return $this->redirectToRoute('home');
    }
}