<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etiquettes')]
class TagController extends AbstractController
{

    #[Route('/{slug}', name:'tag.index', methods: ['GET'])]
    public function index(
        Tag $tag,
        PostRepository $postRepository,
        Request $request
    )
    {
        $posts = $postRepository->findPublished($request->query->getInt("page",1), null, $tag);

        return $this->render("pages/blog/index.html.twig", [
            'tag' => $tag,
            'posts' => $posts
        ]);
    }
}