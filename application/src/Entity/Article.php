<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article Class represent entity class for Articles table on aqarmapTaskDB mysql database
 * @package App\Entity
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="Articles")
 * @ORM\HasLifecycleCallbacks
 */
class Article extends AbstractEntity
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
     * @ORM\Column(type="string", length=500, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10000, nullable=false)
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $publishedAt;

    /**
     * @var ArrayCollection|Comment[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article")
     * @ORM\JoinTable(
     *     name="Article_Comments",
     *     joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")}
     * )
     */
    private $comments;

    /**
     * @var ArrayCollection|Category[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     * @ORM\JoinTable(
     *     name="Article_Categories",
     *     joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->comments   = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * Getting article's id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getting article's title
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setting article's title
     * @param string $title title value
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getting article's content
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setting article's content
     * @param string $content content value
     * @return Article
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Getting publishing date and time for article
     * @return \DateTimeInterface|null
     */
    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Setting article's publish date and time, method fire automatically when add new article
     * @ORM\PrePersist
     */
    public function setPublishedAt()
    {
        $this->publishedAt = new \DateTime("now");
    }

    /**
     * Getting article's author(who create article) instance
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setting article's author
     * @param User $author author instance
     * @return Article
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getting comments on article
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Setting comments under article
     * @param Comment|null $comments array of comments instances
     * @return Article
     */
    public function setComments(?Comment $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Getting categories which article setting under
     * @return ArrayCollection|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Setting categories which article setting under
     * @param Category|null $categories array of categories instances
     * @return Article
     */
    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Adding a comment under article
     * @param Comment $comment comment instance want to add
     * @return Article
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    /**
     * Remove a comment under article
     * @param Comment $comment comment instance want to remove
     * @return Article
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * Adding a category to article
     * @param Category $category category instance want to add
     * @return Article
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    /**
     * Remove a category to article
     * @param Category $category category instance want to remove
     * @return Article
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
