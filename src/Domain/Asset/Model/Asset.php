<?php

namespace App\Domain\Asset\Model;

use App\Domain\Asset\Trait\AssetAttributesAware;
use App\Domain\Core\Model\AbstractDomainModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Asset
    extends AbstractDomainModel
{
    use AssetAttributesAware;

    public function __construct(string $name, string $code, float $activation_cost, int $volume)
    {
        parent::__construct();
        $this->name = $name;
        $this->code = $code;
        $this->activation_cost = $activation_cost;
        $this->volume = $volume;
        $this->availabilities = new ArrayCollection();
    }
}
