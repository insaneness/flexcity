<?php

namespace App\Domain\Core\Handler;

use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;

abstract class UpdateHandler
    extends SaveHandler
{
    protected function getModelFromRequest(SaveRequest $request): DomainModelInterface
    {
        return $request->getDomainModel();
    }
}
