<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{

  #[Route(path:"/like/article/{id}", name:"like.post")]
  #[IsGranted('ROLE_USER')]
  public function like(Post $post, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();	
    if ($post->isLikedByUser($user)) {
      $post->removeLike($user);
      $em->flush();

      return $this->json([
        'message' => 'Like supprimé',
        'nbLikes' => $post->howManyLikes() ,
      ]);
      
    }
    else {
      $post->addLike($user);

      $em->flush();
      return $this->json(
        [
          'message' => 'Like ajouté',
          'nbLikes' => $post->howManyLikes()
        ],
        
      );
    }
  }
}