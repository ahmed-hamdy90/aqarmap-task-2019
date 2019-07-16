<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment Class represent entity class for Article_Comments table on aqarmapTaskDB mysql database
 * @package App\Entity
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="Article_Comments")
 * @ORM\HasLifecycleCallbacks
 */
class Comment extends AbstractEntity
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
     * @ORM\Column(name="comment", type="string", length=500, nullable=false)
     */
    private $content;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinTable(
     *     name="Article_Comments",
     *     joinColumns={@ORM\JoinColumn(name="article-id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $article;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    private $creator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $addedAt;

    /**
     * Getting comment's id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getting comment's content
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setting comment's content
     * @param string $content content value
     * @return Comment
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Getting comment's addition datetime
     * @return \DateTimeInterface|null
     */
    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * Setting comment's addition time, method fire automatically when add new comment
     * @ORM\PrePersist
     */
    public function setAddedAt()
    {
        $this->addedAt = new \DateTime("now");
    }

    /**
     * Getting comment's creator instance
     * @return User|null
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * Setting comment's creator
     * @param User $creator creator instance
     * @return Comment
     */
    public function setCreator(User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Getting article instance which comment belong to
     * @return Article|null
     */
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    /**
     * Setting article instance which comment belong to
     * @param Article $article article instance
     * @return Comment
     */
    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
