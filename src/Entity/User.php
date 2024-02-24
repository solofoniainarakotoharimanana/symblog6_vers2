<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type:"uuid", unique: true)]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    #[UniqueEntity('email', message: 'Cet adresse email est déjà prise.')]
    private ?string $id = null;

    #[ORM\Column(type:'string', length:255)]
    #[Assert\NotBlank()]
    private string $avatar;

    #[ORM\Column(type:'string', length:255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private string $email;

    #[ORM\Column(type:'string', length:255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(type:'string', length:255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull()]
    private $roles = ['ROLE_USER'];

    #[ORM\Column(type:'string', length:255)]
    #[Assert\NotBlank()]
    private ?string $plainPassword = null;

    #[ORM\Column(type:'string', length:255)]
    #[Assert\NotBlank()]
    private string $password;

    #[ORM\Column(type:'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type:'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $updatedAt;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function prePersist()
    {
        $this->avatar = 'https://api.dicebear.com/api/big-ears-neutral/'.$this->email.'svg';
    }

    public function preUpdate()
    {
        $this->avatar = 'https://api.dicebear.com/api/big-ears-neutral/'.$this->email.'svg';
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

     
    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname):self
    {
        $this->firstname = $firstname;

        return $this;
    }
 
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
 
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
 
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
 
    public function setPlainPassword($plainPassword):self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }
 
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getRoles(): array
    {
        $roles =  $this->roles;
        $roles = ['ROLE_USER'];

        return array_unique($roles);
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Returns the identifier for this user (e.g. username or email address).
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
