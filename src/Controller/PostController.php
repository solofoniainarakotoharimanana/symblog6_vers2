<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route(path:"/", name:"post.index", methods: ["GET"])]
    public function index(PostRepository $postRepository): Response
    {

        return $this->render("pages/blog/index.html.twig", 
            [
                'posts' => $postRepository->findPublished()
            ]
        );
    }
}