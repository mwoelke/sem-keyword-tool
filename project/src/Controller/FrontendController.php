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

    #[Route('/domains', name: 'domains', methods: 'GET')]
    public function frontendDomains(): Response
    {
        $domains = $this->domainRepository->findAll();
        return $this->render('domains.html.twig', ['domains' => $domains]);
    }
}
