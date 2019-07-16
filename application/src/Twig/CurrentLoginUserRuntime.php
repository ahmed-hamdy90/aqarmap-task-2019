<?php

namespace App\Twig;

use App\Entity\User;
use App\Exception\NotFoundException;
use App\Service\AqarmapTaskAuthenticationService;
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
     * @var AqarmapTaskAuthenticationService
     */
    private $aqarmapTaskAuthService;

    /**
     * CurrentLoginUserRuntime constructor.
     * @param AqarmapTaskAuthenticationService $authenticationService aqarmap task authentication service instance
     */
    public function __construct(AqarmapTaskAuthenticationService $authenticationService)
    {
        $this->aqarmapTaskAuthService = $authenticationService;
    }

    /**
     * Retrieve the current login user instance on aqarmap task application,
     * if there no user already login will return null
     * @return User|null
     */
    public function getCurrentLoginUser()
    {
        try {
            return $this->aqarmapTaskAuthService->getCurrentLoginUser();
        } catch (NotFoundException $exception) {
            return null;
        }
    }
}
