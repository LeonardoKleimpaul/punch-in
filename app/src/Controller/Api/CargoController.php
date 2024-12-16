<?php

namespace App\Controller\Api;

use App\Entity\Cargo;
use App\Entity\Empresa;
use App\Service\CargoService;
use App\Service\EmpresaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CargoController extends AbstractController
{
    #[Route('/api/admin/cargo/criar', name: 'api_admin_cargo_criar', methods: ['POST'])]
    public function criar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cargoService = new CargoService($em);

        $errors = $cargoService->validateCargo($data);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors['error'],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $cargo = new Cargo();
        $cargo->setFuncao($data['funcao']);

        $cargaHoraria = $cargoService->formataIntervalo($data['cargaHoraria']);
        $cargo->setCargaHoraria($cargaHoraria);

        $cargoService->save($cargo);

        return $this->json(['message' => 'Cargo criado com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
