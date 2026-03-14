<?php

namespace App\Domain\Asset\Trait;

use App\Domain\Asset\Model\Asset;

trait AssetAware
{
    private ?Asset $asset = null;

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): void
    {
        $this->asset = $asset;
    }
}
