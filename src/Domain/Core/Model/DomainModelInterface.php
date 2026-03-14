<?php

namespace App\Domain\Core\Model;

interface DomainModelInterface
{
    public function getId(): ?int;

    public function getUuid(): ?string;

    public function setUuid(string $uuid): void;
}
