<?php

namespace App\Domain\Activation\Repository;

use App\Domain\Activation\Model\Activation;

interface ActivationRepositoryInterface
{
    public function save(Activation $activation): bool;

    public function delete(Activation $activation): bool;
}
