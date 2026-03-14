<?php

namespace App\Domain\Core\Request;

abstract class SaveRequest
{
    private array $validationGroups = [];

    public function getValidationGroups(): array
    {
        return $this->validationGroups;
    }

    public function setValidationGroups(array $validationGroups): void
    {
        $this->validationGroups = $validationGroups;
    }

    public function addValidationGroup(string $validationGroup): void
    {
        if (!in_array($validationGroup, $this->validationGroups, true)) {
            $this->validationGroups[] = $validationGroup;
        }
    }
}
