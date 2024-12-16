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

        return $this->json(['message' => 'Ponto registrado com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
