<?php

namespace App\Controller\Api;

use App\Entity\RegistroPonto;
use App\Service\RegistroPontoService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RegistroPontoController extends AbstractController
{
    #[Route('/api/registrarponto', name: 'api_registrarponto', methods: ['POST'])]
    public function registrarponto(Request $request, EntityManagerInterface $em, Security $security): JsonResponse
    {
        $registroPontoService = new RegistroPontoService($em);

        // $errors = $empresaService->validateEmpresa($data);

        // if (count($errors) > 0) {
        //     return $this->json([
        //         'error' => $errors['error'],
        //     ], JsonResponse::HTTP_BAD_REQUEST);
        // }

        $ponto = new RegistroPonto();
        $ponto->setUsuario($security->getUser());
        $ponto->setDate();

        $registroPontoService->save($ponto);

        return $this->json(['message' => 'Ponto registrado com sucesso!'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/home', name: 'api_home', methods: ['GET'])]
    public function retornaUser(Request $request, Security $security, EntityManagerInterface $em,): JsonResponse
    {
        $user = $security->getUser();
        $registroPontoService = new RegistroPontoService($em);

        return $this->json(['userEmail' => $user->getEmail()], JsonResponse::HTTP_OK);
    }

    #[Route('/api/buscapontos', name: 'api_buscapontos', methods: ['GET'])]
    public function retornaretornaUltimosPontos(Request $request, Security $security, EntityManagerInterface $em,): JsonResponse
    {
        $user = $security->getUser();
        $registroPontoService = new RegistroPontoService($em);
        $pontos = $registroPontoService->retornaUltimosPontosByUser($user->getId());

        return $this->json(['pontos' => $pontos], JsonResponse::HTTP_OK);
    }
}
