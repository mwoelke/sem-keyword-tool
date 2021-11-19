<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('main');
        }

        //get login error if set 
        $error = $authenticationUtils->getLastAuthenticationError();

        //get attempted username
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout() 
    {
        throw new LogicException('Blank method, will be intercepted by logout key on firewall');
    }
}
