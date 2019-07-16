<?php

namespace App\Service\Abstracts;

use App\Repository\Abstracts\AbstractAqarmapTaskDBRepository;
use App\Service\Interfaces\ActiveRecordInterface;

/**
 * AbstractAqarmapTaskDBService Class represent parent service class for every service connect with database on aqarmap task application
 * @package App\Service\Abstracts
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
abstract class AbstractAqarmapTaskDBService extends AbstractService implements ActiveRecordInterface
{
    /**
     * @var AbstractAqarmapTaskDBRepository
     */
    protected $repository;

    /**
     * AbstractAqarmapTaskDBService constructor.
     * @param AbstractAqarmapTaskDBRepository $repository database repository instance
     */
    public function __construct(AbstractAqarmapTaskDBRepository $repository)
    {
        $this->repository = $repository;
    }
}
