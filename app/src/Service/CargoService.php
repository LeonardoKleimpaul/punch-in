<?php

namespace App\Service;

use App\Entity\Cargo;
use Doctrine\ORM\EntityManagerInterface;

class CargoService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Cargo::class);
    }

    public function validateCargo(array $data): array
    {
        $errors = [];

        if (empty($data['funcao']) || empty($data['cargaHoraria'])) {
            return ['error' => 'Função e carga horária são campos obrigatórios.'];
        }

        $errors = $this->verificaFormatoIntervalo($data['cargaHoraria']);

        return $errors;
    }

    public function verificaFormatoIntervalo(string $intervalo): array
    {
        if (preg_match('/^(\d{2}):(\d{2})$/', $intervalo, $matches)) {
            $hours = (int)$matches[1];
            $minutes = (int)$matches[2];

            $interval = new \DateInterval(sprintf('PT%dH%dM', $hours, $minutes));

            if(!$interval instanceof \DateInterval) {
                return ['error' => 'Formato de carga horária inválido. Use HH:MM.'];
            }
        } else {
            return ['error' => 'Formato de carga horária inválido. Use HH:MM.'];
        }

        return [];
    }

    public function formataIntervalo(string $intervalo): \DateInterval
    {
        if (preg_match('/^(\d{2}):(\d{2})$/', $intervalo, $matches)) {
            $hours = (int)$matches[1];
            $minutes = (int)$matches[2];

            // Cria o DateInterval no formato ISO8601
            $interval = new \DateInterval(sprintf('PT%dH%dM', $hours, $minutes));

            return $interval;
        } else {
            throw new \InvalidArgumentException('Formato de carga horária inválido. Use HH:MM.');
        }
    }
}