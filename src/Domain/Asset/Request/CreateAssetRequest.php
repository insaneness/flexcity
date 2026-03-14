<?php

namespace App\Domain\Asset\Request;

use App\Domain\Asset\Trait\AssetAttributesAware;
use App\Domain\Core\Request\CreateRequest;

class CreateAssetRequest
    extends CreateRequest
{
    use AssetAttributesAware;

    private array $rAvailabilities = [];

    public function getRAvailabilities(): array
    {
        return $this->rAvailabilities;
    }

    public function setRAvailabilities(array $r_availabilities): void
    {
        $this->rAvailabilities = $r_availabilities;
    }
}
