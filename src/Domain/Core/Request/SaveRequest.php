<?php

namespace App\Domain\Core\Request;

use App\Domain\Core\Model\DomainModelInterface;

abstract class SaveRequest
{
    public abstract function getDomainModel(): ?DomainModelInterface;
}
