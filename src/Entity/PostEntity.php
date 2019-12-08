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
    private $contentPost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagePost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userPost;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentPost(): ?string
    {
        return $this->contentPost;
    }

    public function setContentPost(?string $contentPost): self
    {
        $this->contentPost = $contentPost;

        return $this;
    }

    public function getImagePost(): ?string
    {
        return $this->imagePost;
    }

    public function setImagePost(?string $imagePost): self
    {
        $this->imagePost = $imagePost;

        return $this;
    }

    public function getUserPost(): ?User
    {
        return $this->userPost;
    }

    public function setUserPost(?User $userPost): self
    {
        $this->userPost = $userPost;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->datePost;
    }

    public function setDatePost(): self
    {
        $this->datePost = new \DateTime("now");
        return $this;
    }
}
