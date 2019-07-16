<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;
use App\Exception\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;


/**
 * User Class represent entity class for Users table on aqarmapTaskDB mysql database
 * @package App\Entity
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="Users")
 */
class User extends AbstractEntity
{
    /**
     * @const User::ADMIN_ROLE represent constant of admin role for user object
     */
    const ADMIN_ROLE = 'admin';

    /**
     * @const User::USER_ROLE represent constant of user role for user object
     */
    const USER_ROLE = 'user';

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $role;

    /**
     * Getting user's id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getting user's username
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Setting user's username
     * @param string $username username value
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Getting user's password
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Setting user's username
     * @param string $password password value
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Getting user's role
     * @return null|string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Setting user's role
     * @param string $role role value
     * @return User
     * @throws InvalidArgumentException if role given has invalid, must be one from @see User::ADMIN_ROLE or @see User::USER_ROLE
     */
    public function setRole(string $role): self
    {
        if (!in_array($role, [self::ADMIN_ROLE, self::USER_ROLE])) {
            throw new InvalidArgumentException("invalid user role");
        }
        $this->role = $role;

        return $this;
    }
}
