<?php

namespace App\Domain\Activation\Handler;

use App\Domain\Activation\Repository\ActivationRepositoryInterface;
use App\Domain\Activation\Request\DeleteActivationRequest;
use App\Domain\Core\Handler\DeleteHandler;

class DeleteActivationHandler
    extends DeleteHandler
{
    public function __construct(private readonly ActivationRepositoryInterface $repository)
    {
    }

    public function handle(DeleteActivationRequest $request): bool
    {
        return $this->repository->delete($request->getActivation());
    }
}
