<?php

namespace App\Domain\Core\Request;

use App\Domain\Core\Model\DomainModelInterface;

abstract class CreateRequest
    extends SaveRequest
{
    public function getDomainModel(): ?DomainModelInterface
    {
        return null;
    }
}
