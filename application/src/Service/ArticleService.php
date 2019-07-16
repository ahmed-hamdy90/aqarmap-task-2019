<?php

namespace App\Service;

use App\Entity\Abstracts\AbstractEntity;
use App\Entity\Article;
use App\Exception\NotFoundException;
use App\Exception\NotImplementException;
use App\Repository\ArticleRepository;
use App\Service\Abstracts\AbstractAqarmapTaskDBService;
use App\Service\Interfaces\ActiveRecordInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * ArticleService Class represent service which responsible for database operation related to article under aqarmap task application
 * @package App\Service
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleService extends AbstractAqarmapTaskDBService
{
    /**
     * @var ManagerRegistry
     */
    private $doctrineManager;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $repository article repository instance
     * @param ManagerRegistry   $manager    doctrine manager instance
     */
    public function __construct(ArticleRepository $repository, ManagerRegistry $manager)
    {
        parent::__construct($repository);
        $this->doctrineManager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): AbstractEntity
    {
        /** @var Article $entity */
        $entity = $this->repository->find($id);

        if (!$entity) {
            throw new NotFoundException("Article not found");
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function findByCriteria(array $criteria, int $counter = ActiveRecordInterface::DEFAULT_COUNTER, int $offset = 0, string $order = ActiveRecordInterface::ASC, string $orderWith = null): array
    {
        $orderCriteria = [];
        if ($orderWith) {
            $orderCriteria  = [$orderWith => $order];
        }
        return $this->repository->findBy($criteria, $orderCriteria, $counter, $offset);
    }

    /**
     * {@inheritdoc}
     * @param Article $entity article want to create
     * @throws NotFoundException if given article was not created
     */
    public function create(AbstractEntity $entity): AbstractEntity
    {
        $entityManager = $this->doctrineManager->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->find($entity->getId());
    }

    /**
     * {@inheritdoc}
     * @throws NotImplementException
     */
    public function update(AbstractEntity $entity): AbstractEntity
    {
        throw new NotImplementException("Method not needed");
    }

    /**
     * {@inheritdoc}
     * @throws NotImplementException
     */
    public function delete(int $id)
    {
        throw new NotImplementException("Method not needed");
    }

    /**
     * Retrieve all possible articles which under given specific category id
     * @param int $categoryId category's id value which filter article with
     * @return array
     */
    public function findByCategoryId(int $categoryId) : array
    {
        return $this->repository->getArticlesFilteredByCategory($categoryId);
    }
}
