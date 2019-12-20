<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @JoinColumn(name="post", referencedColumnName="id", onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentLike", mappedBy="comment")
     */
    private $commentLikes;

    public function __construct()
    {
        $this->commentLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Collection|CommentLike[]
     */
    public function getCommentLikes(): Collection
    {
        return $this->commentLikes;
    }

    public function addCommentLike(CommentLike $commentLike): self
    {
        if (!$this->commentLikes->contains($commentLike)) {
            $this->commentLikes[] = $commentLike;
            $commentLike->setComment($this);
        }

        return $this;
    }

    public function removeCommentLike(CommentLike $commentLike): self
    {
        if ($this->commentLikes->contains($commentLike)) {
            $this->commentLikes->removeElement($commentLike);
            // set the owning side to null (unless already changed)
            if ($commentLike->getComment() === $this) {
                $commentLike->setComment(null);
            }
        }

        return $this;
    }

    /**
     * permet de savoir si un commentaire est liker par un user
     *
     * @param User $user
     * @return bool
     */
    public function isLikedByUser(User $user) : bool
    {
        foreach ($this->commentLikes as $commentLike) {
            if ($commentLike->getUser() === $user) return true;
        }
        return false;
    }
}
