<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function validateUserService(array $data): array
    {
        $errors = [];

        if (empty($data['userId']) || empty($data['cargoId'])) {
            return ['error' => 'Selecione um usuário e um cargo válido.'];
        }

        return $errors;
    }
}