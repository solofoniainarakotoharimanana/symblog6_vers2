<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'slug',
    message:'Ce slug existe déjà !!',
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length: 255,unique: true)]
    #[Assert\NotBlank()]
    private string $name;

    #[ORM\Column(type:"string", length: 255,unique: true)]
    #[Assert\NotBlank()]
    private string $slug = '';

    #[ORM\Column(type:'string', nullable: true)]  
    #[Assert\NotBlank()]  
    private ?string $description = null;

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

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->slug = (new Slugify())->slugify($this->name);
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
 
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug($slug):self
    {
        $this->slug = $slug;

        return $this;
    }
 
    public function getDescription():string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function __toString()
    {

        return $this->name;
    }

}
