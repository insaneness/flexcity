<?php

namespace App\App\DTO\Activation;

use App\App\DTO\AbstractDTO;
use App\Domain\Activation\Model\Activation;

/**
 * @method Activation getDomainModel()
 */
class ActivationDTO
    extends AbstractDTO
{
    public function __construct(Activation $activation)
    {
        $this->setDomainModel($activation);
    }

    public function jsonSerialize(): array
    {
        return [
        ];
    }
}
