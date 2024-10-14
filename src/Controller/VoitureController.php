<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/voitures')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): JsonResponse
    {
        $voitures = $voitureRepository->findAll();
        return $this->json($voitures);
    }

    #[Route('/create', name: 'voiture_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $voiture = new Voiture();
        $voiture->setNumeroImmatriculation($data['numero_immatriculation']);
        $voiture->setUsage($data['usage']);
        $voiture->setEmplacement($data['emplacement']);
        $voiture->setDateAchat(new \DateTime($data['date_achat']));

        $entityManager->persist($voiture);
        $entityManager->flush();

        return $this->json($voiture, JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): JsonResponse
    {
        return $this->json($voiture);
    }

    #[Route('/{id}/update', name: 'voiture_edit', methods: ['POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $voiture->setNumeroImmatriculation($data['numero_immatriculation']);
        $voiture->setUsage($data['usage']);
        $voiture->setEmplacement($data['emplacement']);
        $voiture->setDateAchat(new \DateTime($data['date_achat']));

        $entityManager->flush();

        return $this->json($voiture);
    }

    #[Route('/{id}', name: 'voiture_delete', methods: ['DELETE'])]
    public function delete(Voiture $voiture, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($voiture);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
