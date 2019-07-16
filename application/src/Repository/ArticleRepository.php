<?php

namespace App\Repository;

use App\Entity\Article;
use App\Repository\Abstracts\AbstractAqarmapTaskDBRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * ArticleRepository Class represent repository class of @see Article entity under AqarmapTaskDB database
 * @package App\Repository
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleRepository extends AbstractAqarmapTaskDBRepository
{
    /**
     * ArticleRepository constructor.
     * @param ManagerRegistry $registry doctrine manager registry instance
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Retrieve all possible articles which setting under given category id only
     * @param int $categoryId category's id value want to filter return article with
     * @return array
     */
    public function getArticlesFilteredByCategory(int $categoryId) : array
    {
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.categories', 'c')
            ->addSelect('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $categoryId)
            ->addOrderBy('p.publishedAt', 'DESC')
            ->getQuery();

        return $query->execute();
    }
}
