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
     * @ORM\Column(type="string", length=255)
     */
    private $UserHeart;

    /**
     * @ORM\Column(type="integer")
     */
    private $PostHeart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserHeart(): ?string
    {
        return $this->UserHeart;
    }

    public function setUserHeart(string $UserHeart): self
    {
        $this->UserHeart = $UserHeart;

        return $this;
    }

    public function getPostHeart(): ?int
    {
        return $this->PostHeart;
    }

    public function setPostHeart(int $PostHeart): self
    {
        $this->PostHeart = $PostHeart;

        return $this;
    }
}
