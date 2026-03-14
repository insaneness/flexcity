<?php

namespace App\Domain\Asset\Handler;

use App\Domain\Asset\Availability\Availability;
use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Repository\AssetRepositoryInterface;
use App\Domain\Asset\Request\CreateAssetRequest;
use App\Domain\Core\Handler\CreateHandler;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Asset|null run(SaveRequest $request)
 */
class CreateAssetHandler
    extends CreateHandler
{
    public function __construct(ValidatorInterface $validator,
        private readonly AssetRepositoryInterface $repository)
    {
        parent::__construct($validator);
    }

    public function handle(CreateAssetRequest $request): ?Asset
    {
        return $this->run($request);
    }

    /**
     * @param CreateAssetRequest $request
     * @return Asset
     */
    protected function createModel(SaveRequest $request): DomainModelInterface
    {
        return new Asset($request->getName(), $request->getCode(), $request->getActivationCost(), $request->getVolume());
    }

    protected function completeModel(DomainModelInterface &$model, SaveRequest $request): void
    {
        // No optional attributes to complete
    }

    /**
     * @param Asset $model
     * @param CreateAssetRequest $request
     * @return bool
     */
    protected function save(DomainModelInterface &$model, SaveRequest $request): bool
    {
        // Availability collection
        if (!empty($request->getRAvailabilities())) {
            $processedDates = [];
            foreach ($request->getRAvailabilities() as $availability) {
                $dateStr = $availability['date'] ?? null;

                if (isset($processedDates[$dateStr]) || is_null($dateStr)) {
                    continue;
                }

                $date = \DateTime::createFromFormat('d-m-Y', $dateStr);
                $date->setTime(0,0,0);
                $aModel = new Availability();
                $aModel->setDate($date);
                $model->addAvailability($aModel);

                $processedDates[$dateStr] = true;
            }
        }

        return $this->repository->save($model);
    }
}
