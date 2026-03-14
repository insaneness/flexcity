<?php

namespace App\Domain\Asset\Request;

use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Trait\AssetStrictAware;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\DeleteRequest;

class DeleteAssetRequest
    extends DeleteRequest
{
    use AssetStrictAware;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    public function getDomainModel(): DomainModelInterface
    {
        return $this->asset;
    }
}
