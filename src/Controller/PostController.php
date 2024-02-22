<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    private $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route(path:"/", name:"post.index", methods: ["GET"])]
    public function index(
        PaginatorInterface $paginatorInterface,
        Request $request
        ): Response
    {

        //$datas = $postRepository->findPublished();
        /*$posts = $paginatorInterface->paginate(
                        $datas, 
                        $request->query->getInt("page",1),
                        9
                    );*/

        return $this->render("pages/blog/index.html.twig", 
            [
                'posts' => $this->postRepository->findPublished($request->query->getInt("page",1), null, null)
            ]
        );
    }

    #[Route("/show/{slug}", name: 'post.show', methods: ['GET'])]
    public function show(Post $post):Response //Utilisation de param converter
    {
      
        return $this->render("/pages/blog/show.html.twig", 
                    [
                        'post' => $post
                    ]
                );
    }
}