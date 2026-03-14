<?php

namespace App\Domain\Activation\Model;

use App\Domain\Activation\Trait\ActivationAttributesAware;
use App\Domain\Core\Model\AbstractDomainModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Activation
    extends AbstractDomainModel
{
    use ActivationAttributesAware;
    public function __construct(int $volume, \DateTimeInterface $date)
    {
        parent::__construct();
        $this->volume = $volume;
        $this->date = $date;
        $this->activationAssets = new ArrayCollection();
    }
}
