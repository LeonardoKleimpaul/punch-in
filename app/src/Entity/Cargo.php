<?php

namespace App\Entity;

use App\Repository\CargoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CargoRepository::class)]
class Cargo extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $funcao = null;

    #[ORM\Column]
    private $cargaHoraria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFuncao(): ?string
    {
        return $this->funcao;
    }

    public function setFuncao(string $funcao): static
    {
        $this->funcao = $funcao;

        return $this;
    }

    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    public function setCargaHoraria(\DateInterval $cargaHoraria): static
    {
        $this->cargaHoraria = sprintf('%02d:%02d', $cargaHoraria->h, $cargaHoraria->i);

        return $this;
    }
}
