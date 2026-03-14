<?php

namespace App\Domain\Core\Handler;

use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;

abstract class CreateHandler
    extends SaveHandler
{
    protected abstract function createModel(SaveRequest $request): DomainModelInterface;

    protected abstract function completeModel(DomainModelInterface &$model, SaveRequest $request): void;

    protected function getModelFromRequest(SaveRequest $request): DomainModelInterface
    {
        return $this->createModel($request);
    }
}
