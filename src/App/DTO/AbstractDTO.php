<?php

namespace App\App\DTO;

use App\Domain\Core\Model\DomainModelInterface;

abstract class AbstractDTO
    implements \JsonSerializable
{
    private DomainModelInterface $domainModel;

    public function getDomainModel(): DomainModelInterface
    {
        return $this->domainModel;
    }

    public function setDomainModel(DomainModelInterface $domainModel): void
    {
        $this->domainModel = $domainModel;
    }
}
