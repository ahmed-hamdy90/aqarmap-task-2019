<?php

namespace App\Twig;

use App\Controller\AuthenticationController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * CurrentLoginUserRuntime Class represent Runtime extension of @see CurrentLoginUserExtension Twig extension
 * under aqarmap task application
 * @package App\Twig
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CurrentLoginUserRuntime implements RuntimeExtensionInterface
{
    /**
     * @var SessionInterface
     */
    private $sessionManager;

    /**
     * CurrentLoginUserRuntime constructor.
     * @param SessionInterface $session symfony session instance
     */
    public function __construct(SessionInterface $session)
    {
        $this->sessionManager = $session;
    }

    /**
     * Retrieve the current login user instance on aqarmap task application,
     * if there no user already login will return null
     * @return User|null
     */
    public function getCurrentLoginUser()
    {
        $currentLoginUser =
            $this->sessionManager
                ->get(AuthenticationController::LOGIN_USER_SESSION_KEY, null);

        return (!is_null($currentLoginUser) && is_array($currentLoginUser))? $currentLoginUser[0] : null;
    }
}
