<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ApiLoginService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiLoginController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $apiLoginService = new ApiLoginService($em);

        $errors = $apiLoginService->validateNewUser($data);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors['error'],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (true) {
            return $this->json([
                'error' => 'teste para nao criar no banco',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Criar uma nova instância de User
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']); // Definindo o papel do usuário como 'ROLE_USER'

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Validar a entidade User
        $errors = $validator->validate($user);
        // $errors = []; // Simulando erros de validação

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persistir o usuário no banco de dados
        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User registered successfully!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }
}