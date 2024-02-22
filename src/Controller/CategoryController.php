<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category.index', methods: ['GET'])]
    public function index(Category $category): Response
    {
        
        return $this->render('category/index.html.twig', [
            'posts' => $category->getPosts()->getValues(),
        ]);
    }
}
