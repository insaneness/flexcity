<?php

namespace App\Domain\Activation\Request;

use App\Domain\Activation\Model\Activation;
use App\Domain\Activation\Trait\ActivationStrictAware;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\DeleteRequest;

class DeleteActivationRequest
    extends DeleteRequest
{
    use ActivationStrictAware;

    public function __construct(Activation $activation)
    {
        $this->activation = $activation;
    }

    public function getDomainModel(): DomainModelInterface
    {
        return $this->activation;
    }
}
