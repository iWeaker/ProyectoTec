<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupPostEntityRepository")
 */
class GroupPostEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupEntity", inversedBy="groupPostEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupid;

    /**
     * @ORM\Column(type="text")
     */
    private $contentPost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FilesPostGroupEntity", mappedBy="postGroupId")
     */
    private $filesPostGroupEntities;

    public function __construct()
    {
        $this->filesPostGroupEntities = new ArrayCollection();
    }

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

    public function getContentPost(): ?string
    {
        return $this->contentPost;
    }

    public function setContentPost(string $contentPost): self
    {
        $this->contentPost = $contentPost;

        return $this;
    }

    /**
     * @return Collection|FilesPostGroupEntity[]
     */
    public function getFilesPostGroupEntities(): Collection
    {
        return $this->filesPostGroupEntities;
    }

    public function addFilesPostGroupEntity(FilesPostGroupEntity $filesPostGroupEntity): self
    {
        if (!$this->filesPostGroupEntities->contains($filesPostGroupEntity)) {
            $this->filesPostGroupEntities[] = $filesPostGroupEntity;
            $filesPostGroupEntity->setPostGroupId($this);
        }

        return $this;
    }

    public function removeFilesPostGroupEntity(FilesPostGroupEntity $filesPostGroupEntity): self
    {
        if ($this->filesPostGroupEntities->contains($filesPostGroupEntity)) {
            $this->filesPostGroupEntities->removeElement($filesPostGroupEntity);
            // set the owning side to null (unless already changed)
            if ($filesPostGroupEntity->getPostGroupId() === $this) {
                $filesPostGroupEntity->setPostGroupId(null);
            }
        }

        return $this;
    }
}
