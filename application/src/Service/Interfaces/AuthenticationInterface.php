<?php

namespace App\Service\Interfaces;

use App\Exception\AuthenticationFailedException;

/**
 * AuthenticationInterface Interface include authentication operations need to any service operate with authentication
 * @package App\Service\Interfaces
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
interface AuthenticationInterface
{
    /**
     * Login operation
     * @param string $username user's username which login with
     * @param string $password user's password which login with
     * @return void
     * @throws AuthenticationFailedException if login operation has been failed
     */
    public function login(string $username, string $password);

    /**
     * Logout operation
     * @return void
     */
    public function logout();
}