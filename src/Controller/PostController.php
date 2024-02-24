<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\SearchType;
use App\Model\SearchData;
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
        $searchData = new SearchData;
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $searchData->page = $request->query->getInt("page", 1);
            $posts = $this->postRepository->findBySearch($searchData->q, $searchData->page, $searchData->categories);

            return $this->render("pages/blog/index.html.twig", 
            [
                'posts' => $posts,
                'form' => $form->createView(),
            ]
        );
            
        }

        return $this->render("pages/blog/index.html.twig", 
            [
                'posts' => $this->postRepository->findPublished($request->query->getInt("page",1), null, null),
                'form' => $form->createView(),
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