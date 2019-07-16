<?php

namespace App\Service;

use App\Entity\Abstracts\AbstractEntity;
use App\Entity\Comment;
use App\Exception\NotFoundException;
use App\Exception\NotImplementException;
use App\Repository\CommentRepository;
use App\Service\Abstracts\AbstractAqarmapTaskDBService;
use App\Service\Interfaces\ActiveRecordInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * ArticleCommentService Class represent service which responsible for database operation related to comment on article under aqarmap task application
 * @package App\Service
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleCommentService extends AbstractAqarmapTaskDBService
{
    /**
     * @var ManagerRegistry
     */
    private $doctrineManager;

    /**
     * ArticleCommentService constructor.
     * @param CommentRepository $repository comment repository instance
     * @param ManagerRegistry   $manager    doctrine manager instance
     */
    public function __construct(CommentRepository $repository, ManagerRegistry $manager)
    {
        parent::__construct($repository);
        $this->doctrineManager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): AbstractEntity
    {
        /** @var Comment $entity */
        $entity = $this->repository->find($id);

        if (!$entity) {
            throw new NotFoundException("Comment not found");
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
     * @param Comment $entity comment want to create
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
}
