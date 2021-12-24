<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManagerInterface
    ) {
    }

    #[Route('/', name: 'main', methods: 'GET')]
    public function frontendMain(): Response
    {
        //since this route will always match, we have to check if logged in manually 
        if($this->getUser() === null) {
            //redirect to login if not logged in
            return $this->redirectToRoute('login');
        }
        return $this->render('main.html.twig');
    }

    /**
     * This is a (not so clever?) hack to redirect every 404 GET request to the root page.
     * Since this is a SPA with no persistent state, we need to redirect the user to root if he refreshes on e.g. '/dashboard'
     * Although this seems weird, it works flawlessly lol.
     */
    #[Route('/{route}', methods: 'GET', name: 'refresh-redirect', requirements: ['route' => ".*"], priority: -5)]
    public function redirectToMain(): Response
    {
        return $this->redirectToRoute('main');
    }
}
