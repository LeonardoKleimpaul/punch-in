<?php

namespace App\Service;

use App\Entity\RegistroPonto;
use Doctrine\ORM\EntityManagerInterface;

class RegistroPontoService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, RegistroPonto::class);
    }
}