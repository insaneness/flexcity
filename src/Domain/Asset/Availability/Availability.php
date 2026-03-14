<?php

namespace App\Domain\Asset\Availability;

use App\Domain\Asset\Model\Asset;
use App\Domain\Core\Model\AbstractDomainModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
class Availability
    extends AbstractDomainModel
{
    #[ORM\Column(type: 'datetime')]
    #[Groups(AbstractDomainModel::GROUP_READ)]
    private \DateTimeInterface $date;

    #[ORM\ManyToOne(targetEntity: Asset::class, inversedBy: 'availabilities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Asset $asset = null;

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
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
