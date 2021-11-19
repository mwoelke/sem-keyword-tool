<?php

namespace App\Controller;

use App\Repository\DomainRepository;
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
    /**
     * This is a (not so clever?) hack to rewrite every 404 GET request to the root page.
     * Necessary because symfony will throw 404 for the routes provided by vue-router when accessed explicitely or on page refresh
     * 
     * Although this seems weird, I couldn't find a better way to do it lol.
     */
    #[Route('/{route}', methods: 'GET', name: 'vue-main', requirements: ['route' => ".*"], priority: -5)]
    public function frontendMain(): Response
    {
        //since this route will always match, we have to check if logged in manually 
        if($this->getUser() === null) {
            //redirect to login if not logged in
            return $this->redirectToRoute('login');
        }
        return $this->render('main.html.twig');
    }
}
