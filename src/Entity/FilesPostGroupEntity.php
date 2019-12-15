<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilesPostGroupEntityRepository")
 */
class FilesPostGroupEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupPostEntity", inversedBy="filesPostGroupEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postGroupId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostGroupId(): ?GroupPostEntity
    {
        return $this->postGroupId;
    }

    public function setPostGroupId(?GroupPostEntity $postGroupId): self
    {
        $this->postGroupId = $postGroupId;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }
}
