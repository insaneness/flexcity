<?php

namespace App\Domain\Asset\Request;

use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Trait\AssetAttributesAware;
use App\Domain\Asset\Trait\AssetStrictAware;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\UpdateRequest;

class UpdateAssetRequest
    extends UpdateRequest
{
    use AssetStrictAware;
    use AssetAttributesAware;

    private array $r_availabilities = [];

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    public function getDomainModel(): DomainModelInterface
    {
        return $this->asset;
    }

    public function getRAvailabilities(): array
    {
        return $this->r_availabilities;
    }

    public function setRAvailabilities(array $r_availabilities): void
    {
        $this->r_availabilities = $r_availabilities;
    }
}
