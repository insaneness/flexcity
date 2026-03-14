<?php

namespace App\Infrastructure\Core;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AppRepository
    extends ServiceEntityRepository
{
    protected function saveObject($object): bool
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();

        return true;
    }

    protected function deleteObject($object, bool $detach = true)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
        if ($detach) {
            $this->getEntityManager()->detach($object);
        }

        return true;
    }
}
