<?php

namespace App\Tests\Domain\Service\AssetOptimizer;

use App\Domain\Service\AssetOptimizer\Optimizers\PonderedCostOptimizer;

class PonderedCostOptimizerTest
    extends OptimizerTestCase
{
    public function testFavorsPrecisionWhenPenaltyIsHigh(): void
    {
        $optimizer = new PonderedCostOptimizer(overpowerPenalty: 2.0);

        $assets = [
            $this->createAsset('Asset 1', 'Perfect', 80.0, 100),
            $this->createAsset('Asset 2', 'Too much power', 20.0, 200),
        ];

        $result = $optimizer->optimize(100, $assets);

        $this->assertEquals(80.0, $result->getTotalCost());
        $this->assertEquals(100, $result->getTotalPower());
    }

    public function testFavorsCostWhenPenaltyIsLow(): void
    {
        $optimizer = new PonderedCostOptimizer(overpowerPenalty: 0.01);

        $assets = [
            $this->createAsset('Asset 1', 'Perfect', 80.0, 100),
            $this->createAsset('Asset 2', 'Too much power', 20.0, 200),
        ];

        $result = $optimizer->optimize(100, $assets);

        $this->assertEquals(20.0, $result->getTotalCost());
        $this->assertEquals(200, $result->getTotalPower());
    }

    public function testScoring(): void
    {
        $optimizer = new PonderedCostOptimizer(overpowerPenalty: 0.5);

        $assets = [
            $this->createAsset('Asset 1', 'Option A', 40.0, 110), // Score = 40 + (10 * 0.5) = 45
            $this->createAsset('Asset 2', 'Option B', 30.0, 150), // Score = 30 + (50 * 0.5) = 55
        ];

        $result = $optimizer->optimize(100, $assets);

        $this->assertEquals(40.0, $result->getTotalCost());
        $this->assertEquals(110, $result->getTotalPower());
    }

    public function testSelectsMultipleSmallAssetsForBetterPrecision(): void
    {
        $optimizer = new PonderedCostOptimizer(overpowerPenalty: 1.0);

        $assets = [
            // Big : One big asset, cheap but with a huge overpower
            // Cost: 20 | Power: 180 | Overpower: 80 | Score: 20 + (80 * 1.0) = 100
            $this->createAsset('1', 'Big', 15.0, 180),

            // Smalls : Three smaller assets, more expensive but with a lower overpower
            // Cost: 25 (10+10+5) | Power: 105 (40+40+25) | Overpower: 5 | Score: 25 + (5 * 1.0) = 30
            $this->createAsset('2', 'Small A', 10.0, 40),
            $this->createAsset('3', 'Small B', 10.0, 40),
            $this->createAsset('4', 'Small C', 5.0, 25),
        ];

        $result = $optimizer->optimize(100, $assets);

        // With ponderation at 1 optimizer should prefer the smaller assets with a better score, even if they are more expensive
        $this->assertEquals(25.0, $result->getTotalCost());
        $this->assertEquals(105, $result->getTotalPower());
        $this->assertCount(3, $result->getAssets());

        $names = [];
        foreach($result->getAssets() as $asset) {
            $names[] = $asset->getName();
        }
        $this->assertContains('2', $names);
        $this->assertContains('3', $names);
        $this->assertContains('4', $names);
        $this->assertNotContains('1', $names);
    }
}
