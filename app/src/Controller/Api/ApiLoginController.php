<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserRegisterType;
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
    #[Route('/api/registrar', name: 'api_registrar', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse {
        $user = new User();
        $userService = new UserService($em);

        $userForm = $this->createForm(UserRegisterType::class, $user);
        $userForm->submit(json_decode($request->getContent(), true));

        if ($userForm->isValid()) {
            $user = $userForm->getData();

            $user->setRoles(['ROLE_USER']);

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $userService->save($user);

            return $this->json([
                'status' => 'success',
                'message' => 'Usuário criado com sucesso!'
            ], JsonResponse::HTTP_CREATED);
        }

        $errosForm = $userForm->getErrors(true);
        $erro = [];

        if (count($errosForm) > 0) {
            foreach ($errosForm as $error) {
                $campo = $error->getOrigin()->getName();
                $erro[$campo][] = $error->getMessage();
            }
        } else {
            $erro = ['mensagem' => 'Não foi possível gravar a informação'];
        }

        return $this->json([
            'status' => 'error',
            'erros' => $erro
        ], JsonResponse::HTTP_BAD_REQUEST);
    }
}
