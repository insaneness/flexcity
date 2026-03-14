<?php

namespace App\Domain\Asset\Handler;

use App\Domain\Asset\Availability\Availability;
use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Repository\AssetRepositoryInterface;
use App\Domain\Asset\Request\UpdateAssetRequest;
use App\Domain\Core\Handler\UpdateHandler;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Asset|null run(SaveRequest $request)
 */
class UpdateAssetHandler
    extends UpdateHandler
{

    public function __construct(ValidatorInterface $validator,
        private readonly AssetRepositoryInterface $repository)
    {
        parent::__construct($validator);
    }

    public function handle(UpdateAssetRequest $request): ?Asset
    {
        return $this->run($request);
    }

    /**
     * @param Asset $model
     * @param UpdateAssetRequest $request
     * @return void
     */
    protected function completeModel(DomainModelInterface &$model, SaveRequest $request): void
    {
        $model->setName($request->getName());
        $model->setCode($request->getCode());
        $model->setVolume($request->getVolume());
        $model->setActivationCost($request->getActivationCost());
    }

    /**
     * @param Asset $model
     * @param UpdateAssetRequest $request
     * @return bool
     */
    protected function save(DomainModelInterface &$model, SaveRequest $request): bool
    {
        // Availability collection
        if (!empty($request->getRAvailabilities())) {
            $model->removeAllAvailabilities();
            foreach ($request->getRAvailabilities() as $availability) {
                $date = \DateTime::createFromFormat('d-m-Y', $availability['date']);
                $aModel = new Availability();
                $aModel->setDate($date);
                $model->addAvailability($aModel);
            }
        }

        return $this->repository->save($model);
    }
}
