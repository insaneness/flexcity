<?php

namespace App\Domain\Asset\Handler;

use App\Domain\Asset\Repository\AssetRepositoryInterface;
use App\Domain\Asset\Request\DeleteAssetRequest;
use App\Domain\Core\Handler\DeleteHandler;

class DeleteAssetHandler
    extends DeleteHandler
{
    public function __construct(private readonly AssetRepositoryInterface $repository)
    {
    }

    public function handle(DeleteAssetRequest $request): bool
    {
        return $this->repository->delete($request->getAsset());
    }
}
