<?php

namespace App\DataFixtures;

use App\Domain\Asset\Availability\Availability;
use App\Domain\Asset\Model\Asset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $asset1 = new Asset("Asset 1", "asset_1_code", 50.0, 100);
        $this->addAvailabilityToAsset($asset1, '2026-03-17');
        $this->addAvailabilityToAsset($asset1, '2026-03-18');
        $this->addAvailabilityToAsset($asset1, '2026-03-19');
        $this->addAvailabilityToAsset($asset1, '2026-03-20');
        $manager->persist($asset1);
        $manager->flush();

        $asset2 = new Asset("Asset 2", "asset_2_code", 60.0, 120);
        $this->addAvailabilityToAsset($asset2, '2026-03-17');
        $this->addAvailabilityToAsset($asset2, '2026-03-18');
        $manager->persist($asset2);
        $manager->flush();

        $asset3 = new Asset("Asset 3", "asset_3_code", 55.0, 102);
        $this->addAvailabilityToAsset($asset3, '2026-03-17');
        $this->addAvailabilityToAsset($asset3, '2026-03-18');
        $this->addAvailabilityToAsset($asset3, '2026-03-19');
        $manager->persist($asset3);
        $manager->flush();

        $asset4 = new Asset("Asset 4", "asset_4_code", 40.0, 95);
        $this->addAvailabilityToAsset($asset4, '2026-03-17');
        $manager->persist($asset4);
        $manager->flush();
    }

    private function addAvailabilityToAsset(Asset $asset, string $dateStr): void
    {
        $date = \DateTime::createFromFormat('Y-m-d', $dateStr);
        $date->setTime(0,0,0);
        $availability = new Availability();
        $availability->setDate($date);
        $asset->addAvailability($availability);
    }
}
