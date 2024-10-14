<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/api/clients', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): JsonResponse
    {
        $clients = $clientRepository->findAll();
        return $this->json($clients, 200, [], ['groups' => 'client:read']);
    }

    #[Route('/api/clients/create', name: 'app_client_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client = new Client();
        $client->setNom($data['nom']);
        $client->setPrenom($data['prenom']);
        $client->setDateNaissance(new \DateTime($data['date_naissance']));
        $client->setEstPersonne($data['est_personne']);

        $entityManager->persist($client);
        $entityManager->flush();

        return $this->json($client, 201, [], ['groups' => 'client:read']);
    }

    #[Route('/api/clients/update/{id}', name: 'app_client_update', methods: ['POST'])]
    public function update(int $id, Request $request, ClientRepository $clientRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $client = $clientRepository->find($id);
        if (!$client) {
            return $this->json(['message' => 'Client not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $client->setNom($data['nom']);
        $client->setPrenom($data['prenom']);
        $client->setDateNaissance(new \DateTime($data['date_naissance']));
        $client->setEstPersonne($data['est_personne']);

        $entityManager->flush();

        return $this->json($client, 200, [], ['groups' => 'client:read']);
    }

    #[Route('/api/clients/{id}', name: 'app_client_delete', methods: ['DELETE'])]
    public function delete(int $id, ClientRepository $clientRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $client = $clientRepository->find($id);
        if (!$client) {
            return $this->json(['message' => 'Client not found'], 404);
        }

        $entityManager->remove($client);
        $entityManager->flush();

        return $this->json(['message' => 'Client deleted']);
    }

    #[Route('/api/clients/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(int $id, ClientRepository $clientRepository): JsonResponse
    {
        $client = $clientRepository->find($id);
        if (!$client) {
            return $this->json(['message' => 'Client not found'], 404);
        }

        return $this->json($client, 200, [], ['groups' => 'client:read']);
    }
}
