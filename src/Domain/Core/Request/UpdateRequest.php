<?php

namespace App\Domain\Core\Request;

use App\Domain\Core\Model\DomainModelInterface;

abstract class UpdateRequest
    extends SaveRequest
{
    public abstract function getDomainModel(): DomainModelInterface;
}
