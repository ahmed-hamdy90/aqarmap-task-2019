<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Category Class represent entity class for Users table on aqarmapTaskDB mysql database
 * @package App\Entity
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="Categories")
 */
class Category extends AbstractEntity
{
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * Getting category's id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getting category's name
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setting category's name
     * @param string $name name for category
     * @return Category
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
