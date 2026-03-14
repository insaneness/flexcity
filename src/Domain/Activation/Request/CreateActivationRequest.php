<?php

namespace App\Domain\Activation\Request;

use App\Domain\Activation\Trait\ActivationAttributesAware;
use App\Domain\Activation\Trait\ActivationAware;
use App\Domain\Core\Request\CreateRequest;

class CreateActivationRequest
    extends CreateRequest
{
    use ActivationAware;
    use ActivationAttributesAware;
}
