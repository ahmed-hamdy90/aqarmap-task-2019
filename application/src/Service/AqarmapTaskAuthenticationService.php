<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\AuthenticationFailedException;
use App\Exception\NotFoundException;
use App\Service\Abstracts\AbstractService;
use App\Service\Interfaces\AuthenticationInterface;
use App\Utils\EncryptUserPassword;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * AqarmapTaskAuthenticationService Class represent service which responsible for authentication operations under aqarmap task application
 * @package App\Service
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class AqarmapTaskAuthenticationService extends AbstractService implements AuthenticationInterface
{
    /**
     * @const AqarmapTaskAuthenticationService::LOGIN_USER_SESSION_KEY represent session key of saved login user instance
     */
    const LOGIN_USER_SESSION_KEY = 'loginUser';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var SessionInterface
     */
    private $sessionManager;

    /**
     * AqarmapTaskAuthenticationService constructor.
     * @param UserService      $userService user service instance
     * @param SessionInterface $session     Symfony session manager instance
     */
    public function __construct(UserService $userService, SessionInterface $session)
    {
        $this->userService    = $userService;
        $this->sessionManager = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function login(string $username, string $password)
    {
        $criteria = [
            'username' => $username,
            'password' => (new EncryptUserPassword($password))->encrypt()
        ];
        // check user if exists or not
        $loginUser = $this->userService->findByCriteria($criteria);

        if (!$loginUser) {
            throw new AuthenticationFailedException("User not found");
        }

        // save login user on session
        $this->sessionManager->set(self::LOGIN_USER_SESSION_KEY, $loginUser);
    }

    /**
     * {@inheritdoc}
     */
    public function logout()
    {
        try {
            $this->getCurrentLoginUser();
        } catch (NotFoundException $exception) {
            return;
        }
        // remove login user on session
        $this->sessionManager->remove(self::LOGIN_USER_SESSION_KEY);
    }

    /**
     * Retrieve current login user instance
     * @return User
     * @throws NotFoundException if there no user has been login already
     */
    public function getCurrentLoginUser() : User
    {
        $currentLoginUser =
            $this->sessionManager->get(self::LOGIN_USER_SESSION_KEY, null);

        if (is_null($currentLoginUser)|| !is_array($currentLoginUser)) {
            throw new NotFoundException("There not user login");
        }
        /** @var User $currentLoginUser */
        $currentLoginUser = $currentLoginUser[0];
        // there get User instance with id TODO: search why Symfony see save entity is not exists
        return $this->userService->find($currentLoginUser->getId());
    }
}
