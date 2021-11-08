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
        private EntityManagerInterface $entityManagerInterface,
        private DomainRepository $domainRepository
    ) {
    }

    #[Route('/', name: 'main', methods: 'GET')]
    public function frontendMain(): Response
    {
        return $this->render('main.html.twig');
    }
}
