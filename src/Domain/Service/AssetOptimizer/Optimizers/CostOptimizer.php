<?php

namespace App\Domain\Service\AssetOptimizer\Optimizers;

use App\Domain\Asset\Model\Asset;
use App\Domain\Service\AssetOptimizer\OptimizationResponse;

class CostOptimizer
    extends AbstractOptimizer
{
    /**
     * @param int $targetPower
     * @param Asset[] $assets
     * @return OptimizationResponse
     */
    public function optimize(int $targetPower, array $assets): OptimizationResponse
    {
        $response = $this->check($targetPower, $assets);
        if (!is_null($response)) {
            return $response;
        }

        $this->init($targetPower, $assets);

        $bestPower = $targetPower;
        $minCost = INF;

        for ($p = $targetPower; $p <= $this->maxSearch; $p++) {
            if ($this->dp[$p] < $minCost) {
                $minCost = $this->dp[$p];
                $bestPower = $p;
            }
        }

        $selectedObjects = array_map(fn($id) => $this->assetsById[$id], $this->choices[$bestPower]);

        return new OptimizationResponse(
            totalCost: $minCost,
            totalPower: $bestPower,
            assets: $selectedObjects,
            overPower: $bestPower - $targetPower
        );
    }
}
