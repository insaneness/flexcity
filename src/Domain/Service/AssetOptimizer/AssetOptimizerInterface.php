<?php

namespace App\Domain\Service\AssetOptimizer;

use App\Domain\Asset\Model\Asset;

interface AssetOptimizerInterface
{
    /**
     * @param int $targetPower
     * @param Asset[] $assets
     * @return OptimizationResponse
     */
    public function optimize(int $targetPower, array $assets): OptimizationResponse;
}
