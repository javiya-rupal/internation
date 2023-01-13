<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'group_users')]
    private Collection $user_group;

    public function __construct()
    {
        $this->user_group = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getUserGroup(): Collection
    {
        return $this->user_group;
    }

    public function addUserGroup(Group $userGroup): self
    {
        if (!$this->user_group->contains($userGroup)) {
            $this->user_group->add($userGroup);
        }

        return $this;
    }

    public function removeUserGroup(Group $userGroup): self
    {
        $this->user_group->removeElement($userGroup);

        return $this;
    }
}