<?php

namespace App\Domain\Activation\Trait;

use App\Domain\Activation\ActivationAsset\Model\ActivationAsset;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait ActivationAttributesAware
{
    #[ORM\Column(type: 'integer')]
    #[Assert\Type('integer')]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups([self::GROUP_READ])]
    private ?int $volume = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('\DateTimeInterface')]
    #[Assert\NotNull]
    #[Groups([self::GROUP_READ])]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(targetEntity: ActivationAsset::class, mappedBy: 'activation', cascade: ['persist', 'remove'])]
    #[Groups([self::GROUP_READ])]
    private Collection $activationAssets;

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): void
    {
        $this->volume = $volume;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getActivationAssets(): Collection
    {
        return $this->activationAssets;
    }

    public function addActivationAsset(ActivationAsset $activationAsset): self
    {
        if (!$this->activationAssets->contains($activationAsset)) {
            $this->activationAssets->add($activationAsset);
            $activationAsset->setActivation($this);
        }
        return $this;
    }

    public function removeActivationAsset(ActivationAsset $activationAsset): self
    {
        if ($this->activationAssets->removeElement($activationAsset)) {
            if ($activationAsset->getActivation() === $this) {
                $activationAsset->setActivation(null);
            }
        }
        return $this;
    }
}
