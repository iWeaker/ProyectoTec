<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastM;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastF;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $image;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $cover;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRegister;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostEntity", mappedBy="user_post")
     */
    private $postEntities;

    public function __construct()
    {
        $this->postEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }
    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getLastM(): ?string
    {
        return $this->lastM;
    }

    public function setLastM(string $lastm): self
    {
        $this->lastM = $lastm;

        return $this;
    }
    public function getLastF(): ?string
    {
        return $this->lastF;
    }

    public function setLastF(string $lastF): self
    {
        $this->lastF = $lastF;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDateRegister(): ?\DateTimeInterface
    {
        return $this->dateRegister;
    }

    public function setDateRegister(): self
    {
        //\DateTimeInterface $dateRegister
        //$this->dateRegister = $dateRegister;
        //$this->dateRegister = \DateTime::createFromFormat("d/m/Y H:i","25/04/2015 15:00");
        $this->dateRegister = new \DateTime("now");
        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->id;
    }
    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->user,
            $this->lastM,
            $this->lastF,
            $this->password,
            $this->image,
            $this->cover,
            $this->dateRegister
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->user,
            $this->lastM,
            $this->lastF,
            $this->password,
            $this->image,
            $this->cover,
            $this->dateRegister
            ) = unserialize($serialized,['allowed_classes' => false]);
    }

    /**
     * @return Collection|PostEntity[]
     */
    public function getPostEntities(): Collection
    {
        return $this->postEntities;
    }

    public function addPostEntity(PostEntity $postEntity): self
    {
        if (!$this->postEntities->contains($postEntity)) {
            $this->postEntities[] = $postEntity;
            $postEntity->setUserPost($this);
        }

        return $this;
    }

    public function removePostEntity(PostEntity $postEntity): self
    {
        if ($this->postEntities->contains($postEntity)) {
            $this->postEntities->removeElement($postEntity);
            // set the owning side to null (unless already changed)
            if ($postEntity->getUserPost() === $this) {
                $postEntity->setUserPost(null);
            }
        }

        return $this;
    }
}
