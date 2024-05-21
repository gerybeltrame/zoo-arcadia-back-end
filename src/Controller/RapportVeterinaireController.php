<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;
use DateTimeImmutable;

#[Route('api/rapportVeterinaire', name: 'app_rapportVeterinaire_')]
class RapportVeterinaireController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $rapportVeterinaire = new RapportVeterinaire();
        $rapportVeterinaire->setdate(new DateTimeImmutable());
        $rapportVeterinaire->setdetail('');

        return $this->json(['message', "RapportVeterinaire ressource created with {$rapportVeterinaire->getId()} id"], status: Response::HTTP_CREATED);

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(int $id, RapportVeterinaireRepository $repository): Response
    {
        $rapportveterinaire = $this->$repository->findOneBy(['id'=>$id]);
        if (!$rapportveterinaire) {
            throw $this->createNotFoundException("No Rapport du vétérinaire found for {$id} id");
        }

        return $this->json(
            ['message' => "A Rapport du vétérinaire was found : the {$rapportveterinaire->getdate()} for {$rapportveterinaire->getId()} id"]
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
