<?php

namespace App\Domain\Activation\Trait;

use App\Domain\Activation\Model\Activation;

trait ActivationAware
{
    private ?Activation $activation = null;

    public function getActivation(): ?Activation
    {
        return $this->activation;
    }

    public function setActivation(?Activation $activation): void
    {
        $this->activation = $activation;
    }
}
