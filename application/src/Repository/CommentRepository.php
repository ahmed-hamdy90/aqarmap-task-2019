<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Repository\Abstracts\AbstractAqarmapTaskDBRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * CommentRepository Class represent repository class of @see Comment entity under AqarmapTaskDB database
 * @package App\Repository
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CommentRepository extends AbstractAqarmapTaskDBRepository
{
    /**
     * CommentRepository constructor.
     * @param ManagerRegistry $registry doctrine manager registry instance
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
}
