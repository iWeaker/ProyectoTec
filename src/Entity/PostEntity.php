<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostEntityRepository")
 */
class PostEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content_post;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentPost(): ?string
    {
        return $this->content_post;
    }

    public function setContentPost(?string $content_post): self
    {
        $this->content_post = $content_post;

        return $this;
    }

    public function getImgPost(): ?string
    {
        return $this->img_post;
    }

    public function setImgPost(?string $img_post): self
    {
        $this->img_post = $img_post;

        return $this;
    }

    public function getUserPost(): ?User
    {
        return $this->user_post;
    }

    public function setUserPost(?User $user_post): self
    {
        $this->user_post = $user_post;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->date_post;
    }

    public function setDatePost(\DateTimeInterface $date_post): self
    {
        $this->date_post = $date_post;

        return $this;
    }
}
