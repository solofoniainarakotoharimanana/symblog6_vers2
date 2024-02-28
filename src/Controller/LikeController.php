<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{

  #[Route(path:"/like/article/{id}", name:"like.post")]
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