<?php

namespace App\Entity;

use App\Repository\MentorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MentorRepository::class)]
class Mentor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'mentor', targetEntity: Mentorship::class, orphanRemoval: true)]
    private Collection $mentorships;

    #[ORM\OneToMany(mappedBy: 'mentor', targetEntity: Project::class, orphanRemoval: true)]
    private Collection $projects;

    public function __construct()
    {
        $this->mentorships = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Mentorship>
     */
    public function getMentorships(): Collection
    {
        return $this->mentorships;
    }

    public function addMentorship(Mentorship $mentorship): self
    {
        if (!$this->mentorships->contains($mentorship)) {
            $this->mentorships->add($mentorship);
            $mentorship->setMentor($this);
        }

        return $this;
    }

    public function removeMentorship(Mentorship $mentorship): self
    {
        if ($this->mentorships->removeElement($mentorship)) {
            // set the owning side to null (unless already changed)
            if ($mentorship->getMentor() === $this) {
                $mentorship->setMentor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setMentor($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getMentor() === $this) {
                $project->setMentor(null);
            }
        }

        return $this;
    }
}
