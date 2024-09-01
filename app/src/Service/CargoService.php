<?php

namespace App\Service;

use App\Entity\Empresa;
use Doctrine\ORM\EntityManagerInterface;

class CargoService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Empresa::class);
    }
}