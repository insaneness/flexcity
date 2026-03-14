<?php

namespace App\Domain\Activation\Trait;

use App\Domain\Activation\Model\Activation;

trait ActivationStrictAware
{
    private Activation $activation;

    public function getActivation(): Activation
    {
        return $this->activation;
    }
}
