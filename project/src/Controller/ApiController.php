<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Helper\DomainHelper;
use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    public function __construct(
        private DomainHelper $domainHelper,
        private DomainRepository $domainRepository
    ) {
    }

    /**
     * Get given domain or all domains if called without an ID
     * @param int $id Domain ID
     */
    #[Route('/api/domain/{id}', name: 'apiDomainGet', methods: 'GET', format: 'json')]
    public function apiGetDomain(int $id = 0): Response
    {
        if ($id === 0) {
            $domains = $this->domainRepository->findAll();
        } else {
            $domains = $this->domainRepository->findOneBy(['id' => $id]);
            if ($domains === null) {
                throw new NotFoundHttpException('Domain not found');
            }
        }
        return new JsonResponse($domains, Response::HTTP_OK);
    }
}
