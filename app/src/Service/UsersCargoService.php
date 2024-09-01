<?php

namespace App\Service;

use App\Entity\UsersCargo;
use Doctrine\ORM\EntityManagerInterface;

class UsersCargoService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, UsersCargo::class);
    }
}