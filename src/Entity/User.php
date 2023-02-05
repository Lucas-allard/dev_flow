<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\PostImageController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il y a déjà un compte avec cette adresse email')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            uriTemplate: '/users',
            name: 'post',
        ),
        new Post(
            uriTemplate: '/users/{id}/image',
            controller: PostImageController::class,
            deserialize: false,
            name: 'post_image',
        ),
        new Put(
            uriTemplate: '/users/{id}/image',
            controller: PostImageController::class,
            deserialize: false,
            name: 'put_image_user',
        ),
        new Patch(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ["disable_type_enforcement" => true]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EntityInterface, \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user:read')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups('user:read')]
    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire')]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    #[Assert\Regex(pattern: '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', message: 'L\'adresse email n\'est pas valide')]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups('user:read')]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    #[Assert\NotBlank(message: 'Le nom d\'utilisateur est obligatoire')]
    private ?string $fullName = null;

    #[Vich\UploadableField(mapping: 'post_profile_image', fileNameProperty: 'profilPicturePath')]
    #[Assert\File(maxSize: '5M', mimeTypes: ['image/jpeg', 'image/png', 'image/gif'])]
    #[Ignore]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilPicturePath = null;

    #[Groups('user:read')]
    private ?string $profilPicture = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?string $googleId = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ChatMessage::class, orphanRemoval: true)]
    #[Groups('user:read')]
    private Collection $chatMessages;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?bool $isLogged = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('user:read')]
    private ?\DateTimeInterface $lastActivity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('user:read')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $profilColor = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?int $points = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups('user:read')]
    private ?Level $level = null;

    #[ORM\ManyToMany(targetEntity: Trophy::class, inversedBy: 'users')]
    #[Groups('user:read')]
    private Collection $trophies;


    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Payment::class)]
    #[Groups(['user:read'])]
    private Collection $payments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCourse::class, cascade: ['persist'])]
    #[Groups(['user:read'])]
    private Collection $userCourses;

    #[ORM\Column]
    private ?int $readCount = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserChallenge::class)]
    #[Groups(['user:read'])]
    private Collection $userChallenges;

    #[ORM\Column]
    private ?int $chatMessageCount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('user:read')]
    #[Assert\Length(max: 500, maxMessage: 'La mini-bio ne doit pas dépasser 500 caractères')]
    private ?string $bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    #[Assert\Regex(pattern: '/^(Apprenti|Mentor)$/i', message: 'Le statut n\'est pas valide')]
    private ?string $job = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->readCount = 0;
        $this->chatMessageCount = 0;
        $this->points = 0;
        $this->profilColor = '#' . dechex(random_int(0, 16777215));
        $this->chatMessages = new ArrayCollection();
        $this->trophies = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->userCourses = new ArrayCollection();
        $this->userChallenges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getProfilPicture(): ?string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(?string $profilPicture): self
    {
        $this->profilPicture = $profilPicture;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * @return Collection<ChatMessage>
     */
    public function getChatMessages(): Collection
    {
        return $this->chatMessages;
    }

    public function addChatMessage(ChatMessage $chatMessage): self
    {
        if (!$this->chatMessages->contains($chatMessage)) {
            $this->chatMessages->add($chatMessage);
            $chatMessage->setUser($this);
            $this->chatMessageCount++;
        }

        return $this;
    }

    public function removeChatMessage(ChatMessage $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getUser() === $this) {
                $chatMessage->setUser(null);
                $this->chatMessageCount--;
            }
        }

        return $this;
    }

    public function isIsLogged(): ?bool
    {
        return $this->isLogged;
    }

    public function setIsLogged(bool $isLogged): self
    {
        $this->isLogged = $isLogged;

        return $this;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->lastActivity;
    }

    public function setLastActivity(\DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProfilColor(): ?string
    {
        return $this->profilColor;
    }

    public function setProfilColor(?string $profilColor): self
    {
        $this->profilColor = $profilColor;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Trophy>
     */
    public function getTrophies(): Collection
    {
        return $this->trophies;
    }

    public function addTrophy(Trophy $trophy): self
    {
        if (!$this->trophies->contains($trophy)) {
            $this->trophies->add($trophy);
        }

        return $this;
    }

    public function removeTrophy(Trophy $trophy): self
    {
        $this->trophies->removeElement($trophy);

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
            $payment->setUser($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getUser() === $this) {
                $payment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCourse>
     */
    public function getUserCourses(): Collection
    {
        return $this->userCourses;
    }

    public function getUserCourse(Course $course)
    {
        foreach ($this->userCourses as $userCourse) {
            if ($userCourse->getCourse()->getId() == $course->getId()) {
                return $userCourse;
            }
        }
        return null;
    }

    public function hasCourse($course): bool
    {
        foreach ($this->userCourses as $userCourse) {
            if ($userCourse->getCourse()->getId() == $course->getId()) {
                return true;
            }
        }
        return false;
    }


    public function addUserCourse(UserCourse $userCourse): self
    {
        if (!$this->userCourses->contains($userCourse)) {
            $this->userCourses->add($userCourse);
            $userCourse->setUser($this);
        }

        return $this;
    }

    public function removeUserCourse(UserCourse $userCourse): self
    {
        if ($this->userCourses->removeElement($userCourse)) {
            // set the owning side to null (unless already changed)
            if ($userCourse->getUser() === $this) {
                $userCourse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Vérifie si l'utilisateur a déjà lu le cours donné.
     *
     * @param Course $course
     * @return bool
     */
    public function hasReadCourse(Course $course): bool
    {
        // Itérez à travers les UserCourse de l'utilisateur
        foreach ($this->userCourses as $userCourse) {
            // Vérifiez si le cours de l'objet UserCourse correspond au cours donné
            if ($userCourse->getCourse() === $course && $userCourse->isIsRead()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Course $course
     * @return void
     */
    public function addReadCourse(Course $course): void
    {
        $userCourse = new UserCourse();
        $userCourse->setUser($this);
        $userCourse->setCourse($course);
        $userCourse->setIsRead(true);
        $this->userCourses[] = $userCourse;

    }

    /**
     * Vérifie si l'utilisateur a déjà liké le cours donné.
     *
     * @param Course $course
     * @return bool
     */
    public function hasLikedCourse(Course $course): bool
    {
        // Itérez à travers les UserCourse de l'utilisateur
        foreach ($this->userCourses as $userCourse) {
            // Vérifiez si le cours de l'objet UserCourse correspond au cours donné
            if ($userCourse->getCourse() === $course && $userCourse->isIsLiked()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Course $course
     * @return void
     */
    public function addLikedCourse(Course $course): void
    {
        $userCourse = new UserCourse();
        $userCourse->setUser($this);
        $userCourse->setCourse($course);
        $userCourse->setIsRead(true);
        $this->userCourses[] = $userCourse;
    }


    public function getReadCount(): ?int
    {
        return $this->readCount;
    }

    public function setReadCount(int $readCount): self
    {
        $this->readCount = $readCount;

        return $this;
    }

    /**
     * @return Collection<int, UserChallenge>
     */
    public function getUserChallenges(): Collection
    {
        return $this->userChallenges;
    }

    public function getUserChallenge(Challenge $challenge)
    {
        foreach ($this->userChallenges as $userChallenge) {
            if ($userChallenge->getChallenge()->getId() == $challenge->getId()) {
                return $userChallenge;
            }
        }
        return null;
    }

    public function hasChallenge($challenge): bool
    {
        foreach ($this->userChallenges as $userChallenge) {
            if ($userChallenge->getChallenge()->getId() == $challenge->getId()) {
                return true;
            }
        }
        return false;
    }


    public function addUserChallenge(UserChallenge $userChallenge): self
    {
        if (!$this->userChallenges->contains($userChallenge)) {
            $this->userChallenges->add($userChallenge);
            $userChallenge->setUser($this);
        }

        return $this;
    }

    public function removeUserChallenge(UserChallenge $userChallenge): self
    {
        if ($this->userChallenges->removeElement($userChallenge)) {
            // set the owning side to null (unless already changed)
            if ($userChallenge->getUser() === $this) {
                $userChallenge->setUser(null);
            }
        }

        return $this;
    }

    public function getChatMessageCount(): ?int
    {
        return $this->chatMessageCount;
    }

    public function setChatMessageCount(int $chatMessageCount): self
    {
        $this->chatMessageCount = $chatMessageCount;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->lastActivity = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    /**
     * @return string|null
     */
    public function getProfilPicturePath(): ?string
    {
        return $this->profilPicturePath;
    }

    /**
     * @param string|null $profilPicturePath
     */
    public function setProfilPicturePath(?string $profilPicturePath): void
    {
        $this->profilPicturePath = $profilPicturePath;
    }

    public function serialize(): ?string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->fullName,
            $this->profilPicturePath,
            $this->profilPicture,
            $this->googleId,
            $this->chatMessages,
            $this->roles,
            $this->isLogged,
            $this->lastActivity,
            $this->createdAt,
            $this->profilColor,
            $this->points,
            $this->level,
            $this->trophies,
            $this->payments,
            $this->userCourses,
            $this->readCount,
            $this->userChallenges,
            $this->chatMessageCount,
            $this->address,
            $this->zipCode,
            $this->city,
            $this->bio,
            $this->job,

        ]);
    }

    public function unserialize(string $data)
    {
        // TODO: Implement unserialize() method.
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->fullName,
            $this->profilPicturePath,
            $this->profilPicture,
            $this->googleId,
            ) = unserialize($data, ['allowed_classes' => false]);

    }
}
