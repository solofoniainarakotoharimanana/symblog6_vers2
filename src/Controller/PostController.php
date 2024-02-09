<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route(path:"/", name:"post.index", methods: ["GET"])]
    public function index(
        PostRepository $postRepository,
        PaginatorInterface $paginatorInterface,
        Request $request
        ): Response
    {

        $datas = $postRepository->findPublished();
        $posts = $paginatorInterface->paginate(
                        $datas, 
                        $request->query->getInt("page",1),
                        9
                    );

        return $this->render("pages/blog/index.html.twig", 
            [
                'posts' => $posts
            ]
        );
    }
}