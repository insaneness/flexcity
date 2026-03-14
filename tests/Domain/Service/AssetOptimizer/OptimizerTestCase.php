<?php

namespace App\Tests\Domain\Service\AssetOptimizer;

use App\Domain\Asset\Model\Asset;
use App\Domain\Service\AssetOptimizer\AssetOptimizerInterface;
use PHPUnit\Framework\TestCase;

abstract class OptimizerTestCase
    extends TestCase
{
    protected AssetOptimizerInterface $optimizer;

    protected function createAsset(string $name, string $code, float $cost, int $power): Asset
    {
        return new Asset(
            name: $name,
            code: $code,
            activation_cost: $cost,
            volume: $power);
    }
}
