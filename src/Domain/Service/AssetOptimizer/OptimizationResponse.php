<?php

namespace App\Domain\Service\AssetOptimizer;

class OptimizationResponse
{
    private float $totalCost;

    private int $totalPower;

    private array $assets;

    private int $overPower;

    /**
     * @param float $totalCost
     * @param int $totalPower
     * @param array $assets
     * @param int $overPower
     */
    public function __construct(float $totalCost, int $totalPower, array $assets, int $overPower)
    {
        $this->totalCost = $totalCost;
        $this->totalPower = $totalPower;
        $this->assets = $assets;
        $this->overPower = $overPower;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getTotalPower(): int
    {
        return $this->totalPower;
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function getOverPower(): int
    {
        return $this->overPower;
    }

    public function isUsable(): bool
    {
        return count($this->assets) > 0;
    }
}
