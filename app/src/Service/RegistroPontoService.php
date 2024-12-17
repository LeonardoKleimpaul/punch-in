<?php

namespace App\Service;

use App\Entity\RegistroPonto;
use Doctrine\ORM\EntityManagerInterface;

class RegistroPontoService extends AbstractService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, RegistroPonto::class);
        $this->entityManager = $entityManager;
    }

    public function retornaUltimosPontosByUser($idUser)
    {
        return $this->entityManager->createQueryBuilder('p')
        ->select('p.date')
        ->from(RegistroPonto::class, 'p')
        ->where('p.usuario = :idUser')
        ->setParameter('idUser', $idUser)
        ->orderBy('p.date', 'DESC')
        ->getQuery()
        ->getResult();
    }
}