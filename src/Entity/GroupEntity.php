<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupEntityRepository")
 */
class GroupEntity
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
    private $titleGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groupEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tematica;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $groupImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleGroup(): ?string
    {
        return $this->titleGroup;
    }

    public function setTitleGroup(string $titleGroup): self
    {
        $this->titleGroup = $titleGroup;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getTematica(): ?string
    {
        return $this->tematica;
    }

    public function setTematica(string $tematica): self
    {
        $this->tematica = $tematica;

        return $this;
    }

    public function getGroupImage(): ?string
    {
        return $this->groupImage;
    }

    public function setGroupImage(string $groupImage): self
    {
        $this->groupImage = $groupImage;

        return $this;
    }
}
