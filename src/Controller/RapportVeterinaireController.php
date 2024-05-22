<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

#[Route('api/rapportVeterinaire', name: 'app_rapportVeterinaire_')]
class RapportVeterinaireController extends AbstractController
{
    public function __construct(private RapportVeterinaireRepository $repository, private EntityManagerInterface $manager)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $rapportVeterinaire = new RapportVeterinaire();
        $rapportVeterinaire->setdate(new DateTimeImmutable());
        $rapportVeterinaire->setdetail('');

        return $this->json(
            ['message' => "RapportVeterinaire ressource created with {$rapportVeterinaire->getId()} id"], Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, RapportVeterinaireRepository $repository): Response
    {
        $rapportveterinaire = $this->$repository->findOneBy(['id'=>$id]);
        if (!$rapportveterinaire) {
            throw $this->createNotFoundException("No Rapport du vétérinaire found for {$id} id");
        }

        return $this->json(
            ['message' => "A Rapport du vétérinaire was found : the {$rapportveterinaire->getdate()} for {$rapportveterinaire->getId()} id"], Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);

        if (!$rapportveterinaire) {
            throw $this->createNotFoundException("No Rapport du vétérinaire found for {$id} id");
        }
        
        $rapportveterinaire->setdate('Rapport du vétérinaire date updated');
        $rapportveterinaire->setdetail('Rapport du vétérinaire detail updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_rapportveterinaire_show', ['id' => $rapportveterinaire->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);
        if (!$rapportveterinaire) {
            throw $this->createNotFoundException("No Rapport veterinaire found for {$id} id");
        }

        $this->manager->remove($rapportveterinaire);
        $this->manager->flush();

        return $this->json(['message' => "Rapport vétérinaire resource deleted"], Response::HTTP_NO_CONTENT);

    }
}
