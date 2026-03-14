<?php

namespace App\Domain\Activation\ActivationAsset\Model;

use App\Domain\Activation\Model\Activation;
use App\Domain\Asset\Model\Asset;
use App\Domain\Core\Model\AbstractDomainModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
class ActivationAsset
    extends AbstractDomainModel
{
    #[ORM\ManyToOne(targetEntity: Activation::class, inversedBy: 'activationAssets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activation $activation = null;

    #[ORM\ManyToOne(targetEntity: Asset::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([self::GROUP_READ])]
    private ?Asset $asset = null;

    public function getActivation(): ?Activation
    {
        return $this->activation;
    }

    public function setActivation(?Activation $activation): void
    {
        $this->activation = $activation;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): void
    {
        $this->asset = $asset;
    }
}
