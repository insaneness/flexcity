<?php

namespace App\Domain\Service\AssetOptimizer\Optimizers;

use App\Domain\Service\AssetOptimizer\OptimizationResponse;

class PonderedCostOptimizer
    extends AbstractOptimizer
{
    public function __construct(private float $overpowerPenalty = 0.5)
    {
    }

    public function optimize(int $targetPower, array $assets): OptimizationResponse
    {
        $response = $this->check($targetPower, $assets);
        if (!is_null($response)) {
            return $response;
        }

        $this->init($targetPower, $assets);

        $bestScore = INF;
        $bestPower = -1;

        for ($p = $targetPower; $p <= $this->maxSearch; $p++) {

            if ($this->dp[$p] === INF) {
                continue;
            }

            $overpower = $p - $targetPower;
            $currentScore = $this->dp[$p] + ($overpower * $this->overpowerPenalty);

            if ($currentScore < $bestScore) {
                $bestScore = $currentScore;
                $bestPower = $p;
            }
        }

        if ($bestPower === -1 || $this->dp[$bestPower] === INF) {
            return new OptimizationResponse(0, 0, [], 0);
        }

        // 5. Reconstruction des objets
        $selectedObjects = array_map(fn($id) => $this->assetsById[$id], $this->choices[$bestPower]);

        return new OptimizationResponse(
            $this->dp[$bestPower],
            $bestPower,
            $selectedObjects,
            $bestPower - $targetPower
        );
    }

    public function setOverpowerPenalty(float $overpowerPenalty): void
    {
        $this->overpowerPenalty = $overpowerPenalty;
    }
}
