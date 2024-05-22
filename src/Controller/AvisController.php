<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Avis;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('apis/avis', name: 'app_api_avis_')]

class AvisController extends AbstractController
{
    public function __construct(private AvisRepository $repository, private EntityManagerInterface $manager)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $avis = new Avis();
        $avis->setpseudo('Jean');
        $avis->setcommentaire('Super');

        return $this->json(['message',"Avis resource created with {$avis->getId()} id"],Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
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

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $avis = $this->repository->findOneBy(['id' => $id]);

        if (!$avis) {
            throw $this->createNotFoundException("No Avis found for {$id} id");
        }
        
        $avis->setpseudo('Avis pseudo updated');
        $avis->setcommentaire('Avis commentaire updated');
        $avis->setIsVisible('Avis isVisible updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_avis_show', ['id' => $avis->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
        if (!$avis) {
            throw $this->createNotFoundException("No Avis found for {$id} id");
        }

        $this->manager->remove($avis);
        $this->manager->flush();

        return $this->json(['message' => "Avis resource deleted"], Response::HTTP_NO_CONTENT);

    }


}
