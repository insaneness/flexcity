<?php

namespace App\Domain\Asset\Trait;

use App\Domain\Asset\Model\Asset;

trait AssetStrictAware
{
    private Asset $asset;

    public function getAsset(): Asset
    {
        return $this->asset;
    }
}
