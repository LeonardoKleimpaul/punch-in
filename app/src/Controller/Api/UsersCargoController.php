<?php

namespace App\Controller\Api;

use App\Entity\UsersCargo;
use App\Service\CargoService;
use App\Service\UsersCargoService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UsersCargoController extends AbstractController
{
    #[Route('/api/admin/userscargo/criar', name: 'api_admin_userscargo_criar', methods: ['POST'])]
    public function criar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userService = new UserService($em);
        $cargoService = new CargoService($em);
        $usersCargoService = new UsersCargoService($em);

        $errors = $userService->validateUserService($data);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors['error'],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $userService->findOneBy(['id' => $data['userId']]);
        $cargo = $cargoService->findOneBy(['id' => $data['cargoId']]);

        $usersCargo = new UsersCargo();
        $usersCargo->setUsuario($user);
        $usersCargo->setCargo($cargo);

        $usersCargoService->save($usersCargo);

        return $this->json(['message' => 'Cargo adicionado ao usuário com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
