<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\Voiture;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/devis')]
class DevisController extends AbstractController
{
    #[Route('/', name: 'devis_index', methods: ['GET'])]
    #[Route('/', name: 'devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): JsonResponse
    {
        $devisList = $devisRepository->findAll();
        $data = [];

        foreach ($devisList as $devis) {
            $data[] = [
                'id' => $devis->getId(),
                'numero' => $devis->getNumero(),
                'dateEffet' => $devis->getDateEffet()->format('Y-m-d H:i:s'),
                'prix' => $devis->getPrix(),
                'frequencePrix' => $devis->getFrequencePrix(),
                'client' => $devis->getClient() ? $devis->getClient()->getId() : null,
                'voitures' => array_map(function ($voiture) {
                    return [
                        'id' => $voiture->getId(),
                        'numero_immatriculation' => $voiture->getNumeroImmatriculation(),
                        'usage' => $voiture->getUsage(),
                        'emplacement' => $voiture->getEmplacement(),
                        'date_achat' => $voiture->getDateAchat()->format('Y-m-d'),
                        'client' => $voiture->getClient() ? $voiture->getClient()->getId() : null,
                    ];
                }, $devis->getVoitures()->toArray()),
            ];
        }

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    #[Route('/create', name: 'devis_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $devis = new Devis();
        $devis->setNumero($data['numero']);
        $devis->setDateEffet(new \DateTime($data['date_effet']));
        $devis->setPrix($data['prix']);
        $devis->setFrequencePrix($data['frequence_prix']);

        if (isset($data['client_id'])) {
            $client = $entityManager->getRepository(Client::class)->find($data['client_id']);
            if ($client) {
                $devis->setClient($client);
            } else {
                return $this->json(['error' => 'Client not found'], JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        if (isset($data['voitures']) && is_array($data['voitures'])) {
            foreach ($data['voitures'] as $voitureId) {
                $voiture = $entityManager->getRepository(Voiture::class)->find($voitureId);
                if ($voiture) {
                    $devis->addVoiture($voiture);
                } else {
                    return $this->json(['error' => 'Voiture not found'], JsonResponse::HTTP_BAD_REQUEST);
                }
            }
        }

        $entityManager->persist($devis);
        $entityManager->flush();

        $data = $serializer->serialize($devis, 'json', ['groups' => 'devis:read']);
        return new JsonResponse($data, JsonResponse::HTTP_CREATED, [], true);
    }

    #[Route('/{id}', name: 'devis_show', methods: ['GET'])]
    public function show(int $id, DevisRepository $devisRepository, SerializerInterface $serializer): JsonResponse
    {
        $devis = $devisRepository->find($id);

        if (!$devis) {
            return new JsonResponse(['error' => 'Devis not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $serializer->serialize($devis, 'json', ['groups' => 'devis:read']);
        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{id}/update', name: 'devis_edit', methods: ['POST'])]
    public function edit(Request $request, Devis $devis, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $devis->setNumero($data['numero']);
        $devis->setDateEffet(new \DateTime($data['date_effet']));
        $devis->setPrix($data['prix']);
        $devis->setFrequencePrix($data['frequence_prix']);

        if (isset($data['client_id'])) {
            $client = $entityManager->getRepository(Client::class)->find($data['client_id']);
            if ($client) {
                $devis->setClient($client);
            } else {
                return $this->json(['error' => 'Client not found'], JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        if (isset($data['voitures']) && is_array($data['voitures'])) {
            // Clear existing voitures
            foreach ($devis->getVoitures() as $voiture) {
                $devis->removeVoiture($voiture);
            }

            // Add new voitures
            foreach ($data['voitures'] as $voitureId) {
                $voiture = $entityManager->getRepository(Voiture::class)->find($voitureId);
                if ($voiture) {
                    $devis->addVoiture($voiture);
                } else {
                    return $this->json(['error' => 'Voiture not found'], JsonResponse::HTTP_BAD_REQUEST);
                }
            }
        }

        $entityManager->flush();

        $data = $serializer->serialize($devis, 'json', ['groups' => 'devis:read']);
        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'devis_delete', methods: ['DELETE'])]
    public function delete(Devis $devis, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($devis);
        $entityManager->flush();

        return $this->json(['message' => 'Devis deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
