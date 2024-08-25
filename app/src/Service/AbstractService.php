<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;

abstract class AbstractService
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager, private string $entityClass)
    {
        $this->repository = $this->entityManager->getRepository($this->entityClass);
    }

    public function find(int $id): ?AbstractEntity
    {
        return $this->getRepository()->find($id);
    }

    public function getRepository(): EntityRepository
    {
        return $this->repository;
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?AbstractEntity
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): ?array
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function save(AbstractEntity $entity, ?int $id = null): AbstractEntity
    {
        $this->entityManager->beginTransaction();

        try {
            if(!$id) {
                $this->entityManager->persist($entity);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

            return $entity;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}