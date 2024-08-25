<?php

namespace App\Entity;

abstract class AbstractEntity
{
    public function __tostring(): string
    {
        return $this->getId();
    }
}