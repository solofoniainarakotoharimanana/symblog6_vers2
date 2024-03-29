<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use App\Repository\CategoryRepository;
use App\Repository\Trait\CategoryTagTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'slug',
    message:'Ce slug existe déjà !!',
)]
class Category
{
    use CategoryTagTrait;    
    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categories')]
    #[JoinTable(name: 'categories_posts')]
    private Collection $posts;

    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
    }

    public function getPosts(): Collection
    {

        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if( !$this->posts->contains($post) ) {
            $this->posts[] = $post;
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);

        return $this;
    }

}
