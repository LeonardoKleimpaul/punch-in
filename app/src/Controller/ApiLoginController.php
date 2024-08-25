<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Service\ApiLoginService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'Não foi possível autenticar o usuário.',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/api/registrar', name: 'api_registrar', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $apiLoginService = new ApiLoginService($em);
        $userService = new UserService($em);

        $errors = $apiLoginService->validateNewUser($data);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors['error'],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Criar uma nova instância de User
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $userService->save($user);

        return $this->json(['message' => 'Usuário criado com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
