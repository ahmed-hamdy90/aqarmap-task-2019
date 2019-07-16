<?php

namespace App\Service\Interfaces;

use App\Entity\Abstracts\AbstractEntity;
use App\Exception\NotFoundException;

/**
 * ActiveRecordInterface Interface include active record operations
 * need to implement for every data source(DB) operations under aqamap task application
 * @package App\Service\Interfaces
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
interface ActiveRecordInterface
{
    /**
     * @const ActiveRecordInterface::DESC represent fetching items with descending order
     */
    const DESC = 'DESC';

    /**
     * @const ActiveRecordInterface::ASC represent fetching items with ascending order
     */
    const ASC = 'ASC';

    /**
     * @const ActiveRecordInterface::DEFAULT_COUNTER represent default counter for retrieved items
     */
    const DEFAULT_COUNTER = 100;

    /**
     * Retrieve item using it's id
     * @param int $id item's id value want to retrieve
     * @return AbstractEntity
     * @throws NotFoundException if given item's id was invalid and not exists
     */
    public function find(int $id) : AbstractEntity;

    /**
     * Retrieve items using given criteria
     * @param array $criteria array include criteria want to retrieve items with
     * @param int $counter number of items want to retrieve
     * @param int $offset number which will retrieve items from
     * @param string $order order type for retrieve items
     * @param string|null $orderWith name of item property will order with
     * @return array
     */
    public function findByCriteria(array $criteria, int $counter = ActiveRecordInterface::DEFAULT_COUNTER, int $offset = 0, string $order = ActiveRecordInterface::ASC, string $orderWith = null) : array;

    /**
     * Add new item
     * @param AbstractEntity $entity item instance wanted to add
     * @return AbstractEntity
     */
    public function create(AbstractEntity $entity) : AbstractEntity;

    /**
     * Modifies exists item
     * @param AbstractEntity $entity item instance wanted to modifies
     * @return AbstractEntity
     */
    public function update(AbstractEntity $entity) : AbstractEntity;

    /**
     * Delete exists item using it's id
     * @param int $id item's id value want to delete
     * @return void
     */
    public function delete(int $id);
}
