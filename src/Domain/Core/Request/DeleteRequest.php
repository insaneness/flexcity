<?php

namespace App\Domain\Core\Request;

use App\Domain\Core\Model\DomainModelInterface;

abstract class DeleteRequest
{
    public abstract function getDomainModel(): DomainModelInterface;
}
