<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Mentorship::class, orphanRemoval: true)]
    private Collection $mentorships;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: ProjectTracking::class, orphanRemoval: true)]
    private Collection $projectTrackings;

    public function __construct()
    {
        $this->mentorships = new ArrayCollection();
        $this->projectTrackings = new ArrayCollection();
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
            $mentorship->setStudent($this);
        }

        return $this;
    }

    public function removeMentorship(Mentorship $mentorship): self
    {
        if ($this->mentorships->removeElement($mentorship)) {
            // set the owning side to null (unless already changed)
            if ($mentorship->getStudent() === $this) {
                $mentorship->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectTracking>
     */
    public function getProjectTrackings(): Collection
    {
        return $this->projectTrackings;
    }

    public function addProjectTracking(ProjectTracking $projectTracking): self
    {
        if (!$this->projectTrackings->contains($projectTracking)) {
            $this->projectTrackings->add($projectTracking);
            $projectTracking->setStudent($this);
        }

        return $this;
    }

    public function removeProjectTracking(ProjectTracking $projectTracking): self
    {
        if ($this->projectTrackings->removeElement($projectTracking)) {
            // set the owning side to null (unless already changed)
            if ($projectTracking->getStudent() === $this) {
                $projectTracking->setStudent(null);
            }
        }

        return $this;
    }
}
