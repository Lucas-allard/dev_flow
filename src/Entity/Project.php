<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mentor $mentor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Mentorship::class, orphanRemoval: true)]
    private Collection $mentorships;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectTracking::class, orphanRemoval: true)]
    private Collection $projectTrackings;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Payment::class)]
    private Collection $payments;

    public function __construct()
    {
        $this->mentorships = new ArrayCollection();
        $this->projectTrackings = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getMentor(): ?Mentor
    {
        return $this->mentor;
    }

    public function setMentor(?Mentor $mentor): self
    {
        $this->mentor = $mentor;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

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
            $mentorship->setProject($this);
        }

        return $this;
    }

    public function removeMentorship(Mentorship $mentorship): self
    {
        if ($this->mentorships->removeElement($mentorship)) {
            // set the owning side to null (unless already changed)
            if ($mentorship->getProject() === $this) {
                $mentorship->setProject(null);
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
            $projectTracking->setProject($this);
        }

        return $this;
    }

    public function removeProjectTracking(ProjectTracking $projectTracking): self
    {
        if ($this->projectTrackings->removeElement($projectTracking)) {
            // set the owning side to null (unless already changed)
            if ($projectTracking->getProject() === $this) {
                $projectTracking->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setProject($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getProject() === $this) {
                $payment->setProject(null);
            }
        }

        return $this;
    }
}
