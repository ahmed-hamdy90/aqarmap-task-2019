<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Abstracts\AbstractAqarmapTaskDBRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * UserRepository Class represent repository class of @see User entity under AqarmapTaskDB database
 * @package App\Repository
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class UserRepository extends AbstractAqarmapTaskDBRepository
{
    /**
     * ArticleRepository constructor.
     * @param ManagerRegistry $registry doctrine manager registry instance
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}