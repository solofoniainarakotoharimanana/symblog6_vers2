<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
  #[Route(path:"/connexion", name:"security.login", methods: ["GET", "POST"])]
  public function login(AuthenticationUtils $utils): Response
  {
    $error = $utils->getLastAuthenticationError();
    $lastUsername = $utils->getLastUsername();

    return $this->render("pages/security/login.html.twig", [
      'error' => $error,
      'last_username' => $lastUsername
    ]);
  }

  #[Route("/deconnexion", name: "security.logout", methods: ["GET"])]
  public function logout(AuthenticationUtils $utils): Void
  {
    //Nothing to do here
  }
}