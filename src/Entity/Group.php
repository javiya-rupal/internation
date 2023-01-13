<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $groupname = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'user_group')]
    #[JoinTable(name: 'group_users')]
    private Collection $group_users;

    public function __construct()
    {
        $this->group_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupname(): ?string
    {
        return $this->groupname;
    }

    public function setGroupname(string $groupname): self
    {
        $this->groupname = $groupname;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getGroupUsers(): Collection
    {
        return $this->group_users;
    }

    public function addGroupUser(User $groupUser): self
    {
        if (!$this->group_users->contains($groupUser)) {
            $this->group_users->add($groupUser);
            $groupUser->addUserGroup($this);
        }

        return $this;
    }

    public function removeGroupUser(User $groupUser): self
    {
        if ($this->group_users->removeElement($groupUser)) {
            $groupUser->removeUserGroup($this);
        }

        return $this;
    }
}