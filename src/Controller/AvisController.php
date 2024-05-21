<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Avis;
use App\Repository\AvisRepository;

#[Route('apis/avis', name: 'app_api_avis_')]

class AvisController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $avis = new Avis();
        $avis->setpseudo('Jean');
        $avis->setcommentaire('Super');

        return $this->json(['message',"Avis resource created with {$avis->getId()} id"],Response::HTTP_CREATED);

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(int $id, AvisRepository $repository): Response
    {
        $avis = $this->$repository->findOneBy(['id'=>$id]);
        if (!$avis) {
            throw $this->createNotFoundException("No avis found for {$id} id");
        }

        return $this->json(
            ['message' => "An avis was found : from {$avis->getpseudo()} of {$avis->getId()} id is visible{$avis->getIsVisible()}"]
        );

    }

    #[Route('/', name: 'edit', methods: ['PUT'])]
    public function edit(): Response
    {

    }

    #[Route('/', name: 'delete', methods: ['DELETE'])]
    public function delete(): Response
    {

    }


}
