<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HeartEntityRepository")
 */
class HeartEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostEntity", inversedBy="heartEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="heartEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userHeartId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?PostEntity
    {
        return $this->post_id;
    }

    public function setPostId(?PostEntity $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getUserHeartId(): ?User
    {
        return $this->userHeartId;
    }

    public function setUserHeartId(?User $userHeartId): self
    {
        $this->userHeartId = $userHeartId;

        return $this;
    }
}
