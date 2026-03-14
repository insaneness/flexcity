<?php

namespace App\Domain\Asset\Trait;

use App\Domain\Asset\Availability\Availability;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait AssetAttributesAware
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Groups([self::GROUP_READ])]
    private ?string $code = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Groups([self::GROUP_READ])]
    private ?string $name = null;

    #[ORM\Column(type: 'float')]
    #[Assert\Type('float')]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups([self::GROUP_READ])]
    private ?float $activation_cost = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Type('integer')]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups([self::GROUP_READ])]
    private ?int $volume = null;

    #[ORM\OneToMany(targetEntity: Availability::class, mappedBy: 'asset', cascade: ['persist', 'remove'])]
    #[Groups([self::GROUP_READ])]
    private Collection $availabilities;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getActivationCost(): ?float
    {
        return $this->activation_cost;
    }

    public function setActivationCost(?float $activation_cost): void
    {
        $this->activation_cost = $activation_cost;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): void
    {
        $this->volume = $volume;
    }

    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities->add($availability);
            $availability->setAsset($this);
        }
        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getAsset() === $this) {
                $availability->setAsset(null);
            }
        }
        return $this;
    }

    public function removeAllAvailabilities(): void
    {
        foreach ($this->availabilities as $availability) {
            $this->removeAvailability($availability);
        }
    }
}
