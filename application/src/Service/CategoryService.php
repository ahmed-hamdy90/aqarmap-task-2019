<?php

namespace App\Service;

use App\Entity\Abstracts\AbstractEntity;
use App\Entity\Category;
use App\Exception\NotFoundException;
use App\Exception\NotImplementException;
use App\Repository\CategoryRepository;
use App\Service\Abstracts\AbstractAqarmapTaskDBService;
use App\Service\Interfaces\ActiveRecordInterface;

/**
 * CategoryService Class represent service which responsible for database operation related to category under aqarmap task application
 * @package App\Service
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class CategoryService extends AbstractAqarmapTaskDBService
{
    /**
     * CategryService constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): AbstractEntity
    {
        /** @var Category $entity */
        $entity = $this->repository->find($id);

        if (!$entity) {
            throw new NotFoundException("Category not found");
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
     * @throws NotImplementException
     */
    public function create(AbstractEntity $entity): AbstractEntity
    {
        throw new NotImplementException("Method not needed");
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

