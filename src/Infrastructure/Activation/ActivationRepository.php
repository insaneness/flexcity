<?php

namespace App\Infrastructure\Activation;

use App\Domain\Activation\Model\Activation;
use App\Domain\Activation\Repository\ActivationRepositoryInterface;
use App\Infrastructure\Core\AppRepository;
use Doctrine\Persistence\ManagerRegistry;

class ActivationRepository
    extends AppRepository
    implements ActivationRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activation::class);
    }

    public function save(Activation $activation): bool
    {
        return $this->saveObject($activation);
    }

    public function delete(Activation $activation): bool
    {
        return $this->deleteObject($activation);
    }
}
