<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ApiLoginService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function validateNewUser(array $data): array
    {
        $errors = [];

        if (empty($data['email']) || empty($data['password'])) {
            return ['error' => 'Email e senha são campos obrigatórios.'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Email inválido.'];
        }

        if(mb_strlen($data['password']) < 8) {
            return ['error' => 'A senha precisa ter pelo menos 8 caracteres.'];
        }

        $userService = new UserService($this->getEntityManager());

        if($userService->findOneBy(['email' => $data['email']])) {
            return ['error' => 'Já existe um usuário cadastrado com este email.'];
        }

        return $errors;
    }

}