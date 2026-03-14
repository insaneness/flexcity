<?php

namespace App\Domain\Asset\Repository;

use App\Domain\Asset\Model\Asset;

interface AssetRepositoryInterface
{
    public function save(Asset $asset): bool;
    public function delete(Asset $asset): bool;

    /**
     * @param \DateTime $date
     * @return Asset[]
     */
    public function findByAvailabilityDate(\DateTime $date): array;
}
