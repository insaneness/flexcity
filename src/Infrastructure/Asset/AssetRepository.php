<?php

namespace App\Infrastructure\Asset;

use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Repository\AssetRepositoryInterface;
use App\Infrastructure\Core\AppRepository;
use Doctrine\Persistence\ManagerRegistry;

class AssetRepository
    extends AppRepository
    implements AssetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asset::class);
    }

    public function save(Asset $asset): bool
    {
        return $this->saveObject($asset);
    }

    public function delete(Asset $asset): bool
    {
        return $this->deleteObject($asset);
    }

    /**
     * @param \DateTime $date
     * @return Asset[]
     */
    public function findByAvailabilityDate(\DateTime $date): array
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.availabilities', 'av')
            ->where('av.date = :date')
            ->setParameter('date', $date);

        return $qb->getQuery()->getResult();
    }
}
