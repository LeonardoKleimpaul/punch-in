<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Service\EmpresaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EmpresaController extends AbstractController
{
    #[Route('/api/admin/empresa/criar', name: 'api_admin_empresa_criar', methods: ['POST'])]
    public function criar(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $empresaService = new EmpresaService($em);

        $errors = $empresaService->validateEmpresa($data);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors['error'],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $empresa = new Empresa();
        $empresa->setNome($data['nome']);
        $empresa->setCnpj($data['cnpj']);

        $empresaService->save($empresa);

        return $this->json(['message' => 'Empresa criada com sucesso!'], JsonResponse::HTTP_CREATED);
    }
}
