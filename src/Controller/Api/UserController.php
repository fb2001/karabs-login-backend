<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $jsonContent = $serializer->serialize($users, 'json');
        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/api/users', name: 'create_user', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // Récupérer les données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données sont complètes
        if (!isset($data['nom'], $data['prenom'], $data['email'], $data['password'], $data['ville'], $data['codePostal'])) {
            return new JsonResponse(['message' => 'Les données sont incomplètes'], 400);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT)); // Hashage du mot de passe
        $user->setVille($data['ville']);
        $user->setCodePostal($data['codePostal']);

        // Validation de l'utilisateur
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => 'Les données sont invalides', 'errors' => (string) $errors], 400);
        }

        // Sauvegarder l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès', 'id' => $user->getId()], 201);
    }
}