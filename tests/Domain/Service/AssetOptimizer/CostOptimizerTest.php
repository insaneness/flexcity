<?php

namespace App\Tests\Domain\Service\AssetOptimizer;

use App\Domain\Service\AssetOptimizer\Optimizers\CostOptimizer;

class CostOptimizerTest
    extends OptimizerTestCase
{
    protected function setUp(): void
    {
        $this->optimizer = new CostOptimizer();
    }

    public function testPickCheapestEvenWithHugeOverpower(): void
    {
        $assets = [
            $this->createAsset('Asset 1', 'Précise but costly', 100.0, 100),
            $this->createAsset('Asset 2', 'Low cost but huge overpower', 10.0, 500),
        ];

        $result = $this->optimizer->optimize(100, $assets);

        $this->assertEquals(10.0, $result->getTotalCost());
        $this->assertEquals(500, $result->getTotalPower());
        $this->assertCount(1, $result->getAssets());
    }

    public function testFindBestCombinationOfSmallAssets(): void
    {
        $assets = [
            $this->createAsset('Asset 1', 'Big', 50.0, 100),
            $this->createAsset('Asset 2', 'Small A', 15.0, 50),
            $this->createAsset('Asset 3', 'Small B', 15.0, 60),
        ];

        $result = $this->optimizer->optimize(100, $assets);

        $this->assertEquals(30.0, $result->getTotalCost());
        $this->assertEquals(110, $result->getTotalPower());
        $this->assertCount(2, $result->getAssets());
    }

    public function testReturnsEmptyResultIfNoAssets(): void
    {
        $result = $this->optimizer->optimize(100, []);

        $this->assertEquals(0, $result->getTotalCost());
        $this->assertEmpty($result->getAssets());
    }

    public function testNotEnoughPowerInAssets(): void
    {
        $assets = [
            $this->createAsset('Asset 1', 'Small A', 50.0, 30),
            $this->createAsset('Asset 2', 'Small B', 20.0, 40),
        ];

        $result = $this->optimizer->optimize(100, $assets);

        $this->assertCount(0, $result->getAssets());
    }
}
