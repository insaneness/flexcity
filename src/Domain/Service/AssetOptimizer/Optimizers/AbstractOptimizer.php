<?php

namespace App\Domain\Service\AssetOptimizer\Optimizers;

use App\Domain\Service\AssetOptimizer\AssetOptimizerInterface;
use App\Domain\Service\AssetOptimizer\OptimizationResponse;

abstract class AbstractOptimizer
    implements AssetOptimizerInterface
{
    protected array $choices;
    protected array $dp;
    protected int $maxSearch;
    protected array $assetsById;

    protected function check(int $targetPower, array $assets): ?OptimizationResponse
    {
        if ($targetPower <= 0) {
            return new OptimizationResponse(0, 0, [], 0);
        }
        if (empty($assets)) {
            return new OptimizationResponse(0, 0, [], 0);
        }

        return null;
    }

    protected function init(int $targetPower, array $assets)
    {
        $maxPowerInAssets = max(array_map(fn($a) => $a->getVolume(), $assets));
        $this->maxSearch = $targetPower + $maxPowerInAssets;

        $this->assetsById = [];
        foreach ($assets as $asset) {
            $this->assetsById[$asset->getUuid()] = $asset;
        }

        // Initialisation
        $this->dp = array_fill(0, $this->maxSearch + 1, INF);
        $this->choices = array_fill(0, $this->maxSearch + 1, []);
        $this->dp[0] = 0;

        // dynamic programming
        foreach ($assets as $asset) {
            $id = $asset->getUuid();
            $volume = $asset->getVolume();
            $cost = $asset->getActivationCost();

            for ($p = $this->maxSearch - $volume; $p >= 0; $p--) {
                if ($this->dp[$p] === INF) continue;

                $newVolume = $p + $volume;
                $newCost = $this->dp[$p] + $cost;

                if ($newCost < $this->dp[$newVolume]) {
                    $this->dp[$newVolume] = $newCost;

                    $this->choices[$newVolume] = $this->choices[$p];
                    $this->choices[$newVolume][] = $id;
                }
            }
        }
    }
}
