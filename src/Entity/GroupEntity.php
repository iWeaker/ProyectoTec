<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SolicitudesEntity", mappedBy="groupid")
     */
    private $solicitudesEntities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AceptedEntity", mappedBy="groupid")
     */
    private $aceptedEntities;

    public function __construct()
    {
        $this->solicitudesEntities = new ArrayCollection();
        $this->aceptedEntities = new ArrayCollection();
    }



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

    /**
     * @return Collection|SolicitudesEntity[]
     */
    public function getSolicitudesEntities(): Collection
    {
        return $this->solicitudesEntities;
    }

    public function addSolicitudesEntity(SolicitudesEntity $solicitudesEntity): self
    {
        if (!$this->solicitudesEntities->contains($solicitudesEntity)) {
            $this->solicitudesEntities[] = $solicitudesEntity;
            $solicitudesEntity->setGroupid($this);
        }

        return $this;
    }

    public function removeSolicitudesEntity(SolicitudesEntity $solicitudesEntity): self
    {
        if ($this->solicitudesEntities->contains($solicitudesEntity)) {
            $this->solicitudesEntities->removeElement($solicitudesEntity);
            // set the owning side to null (unless already changed)
            if ($solicitudesEntity->getGroupid() === $this) {
                $solicitudesEntity->setGroupid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AceptedEntity[]
     */
    public function getAceptedEntities(): Collection
    {
        return $this->aceptedEntities;
    }

    public function addAceptedEntity(AceptedEntity $aceptedEntity): self
    {
        if (!$this->aceptedEntities->contains($aceptedEntity)) {
            $this->aceptedEntities[] = $aceptedEntity;
            $aceptedEntity->setGroupid($this);
        }

        return $this;
    }

    public function removeAceptedEntity(AceptedEntity $aceptedEntity): self
    {
        if ($this->aceptedEntities->contains($aceptedEntity)) {
            $this->aceptedEntities->removeElement($aceptedEntity);
            // set the owning side to null (unless already changed)
            if ($aceptedEntity->getGroupid() === $this) {
                $aceptedEntity->setGroupid(null);
            }
        }

        return $this;
    }



}
