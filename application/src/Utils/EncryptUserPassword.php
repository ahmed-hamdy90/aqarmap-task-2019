<?php

namespace App\Utils;

/**
 * EncryptUserPassword Class represent utility class which responsible for encrypt given user's plain password
 * according to encryption methodology used for
 * @package App\Utils
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class EncryptUserPassword
{
    /**
     * @var string
     */
    private $plainPassword;

    /**
     * EncryptUserPassword constructor.
     * @param string $password user's plain password value want to encrypt
     */
    public function __construct(string $password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Encrypt given user's password
     * @return string
     */
    public function encrypt() : string
    {
        return sha1($this->plainPassword);
    }
}