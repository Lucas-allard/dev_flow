<?php

namespace App\Entity;

use App\Repository\UserCourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UserCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isRead = null;

    #[ORM\ManyToOne(inversedBy: 'userCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\Column]
    private ?bool $isLiked = null;

    #[ORM\Column]
    private ?bool $hasRead = null;

    #[ORM\Column]
    private ?bool $hasLiked = null;

    public function __construct()
    {
        $this->isLiked = false;
        $this->hasLiked = false;
        $this->isRead = false;
        $this->hasRead = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function isIsLiked(): ?bool
    {
        return $this->isLiked;
    }

    public function setIsLiked(bool $isLiked): self
    {
        $this->isLiked = $isLiked;

        return $this;
    }

    public function isHasRead(): ?bool
    {
        return $this->hasRead;
    }

    public function setHasRead(bool $hasRead): self
    {
        $this->hasRead = $hasRead;

        return $this;
    }

    public function isHasLiked(): ?bool
    {
        return $this->hasLiked;
    }

    public function setHasLiked(bool $hasLiked): self
    {
        $this->hasLiked = $hasLiked;

        return $this;
    }
}
