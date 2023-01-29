<?php

namespace App\Entity;

use App\Repository\TrophyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TrophyRepository::class)]
class Trophy implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('user:read')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('user:read')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?int $requiredPoint = null;

    #[ORM\OneToOne(inversedBy: 'trophy', cascade: ['persist', 'remove'])]
    private ?Challenge $challenge = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'trophies')]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?int $requiredMessage = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRequiredPoint(): ?int
    {
        return $this->requiredPoint;
    }

    public function setRequiredPoint(?int $requiredPoint): self
    {
        $this->requiredPoint = $requiredPoint;

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addTrophy($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTrophy($this);
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getRequiredMessage(): ?int
    {
        return $this->requiredMessage;
    }

    public function setRequiredMessage(?int $requiredMessage): self
    {
        $this->requiredMessage = $requiredMessage;

        return $this;
    }
}
