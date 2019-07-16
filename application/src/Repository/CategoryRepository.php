<?php

namespace App\Repository;

use App\Entity\Category;
use App\Repository\Abstracts\AbstractAqarmapTaskDBRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * CategoryRepository Class represent repository class of @see Category entity under AqarmapTaskDB database
 * @package App\Repository
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CategoryRepository extends AbstractAqarmapTaskDBRepository
{
    /**
     * CategoryRepository constructor.
     * @param ManagerRegistry $registry doctrine manager registry instance
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
