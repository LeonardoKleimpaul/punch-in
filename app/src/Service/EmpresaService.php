<?php

namespace App\Service;

use App\Entity\Empresa;
use Doctrine\ORM\EntityManagerInterface;

class EmpresaService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Empresa::class);
    }

    public function validateEmpresa(array $data): array
    {
        $errors = [];

        if (empty($data['nome']) || empty($data['cnpj'])) {
            return ['error' => 'Nome e cnpj são campos obrigatórios.'];
        }

        if($this->findOneBy([])) {
            return ['error' => 'Não é possível criar mais de uma empresa.'];
        }

        return $errors;
    }
}