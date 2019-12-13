<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AceptedEntityRepository")
 */
class AceptedEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupEntity", inversedBy="aceptedEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="aceptedEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupid(): ?GroupEntity
    {
        return $this->groupid;
    }

    public function setGroupid(?GroupEntity $groupid): self
    {
        $this->groupid = $groupid;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
