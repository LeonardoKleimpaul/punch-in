<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

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

    public function save(AbstractEntity $entity, ?int $id = null): AbstractEntity
    {

        if($this->findOneBy(['email' => $entity->getEmail()])) {
            throw new ConflictHttpException('Já existe um usuário cadastrado com este e-mail.');
        }

        return parent::save($entity, $id);
    }
}