<?php

namespace App\Domain\Activation\Handler;

use App\Domain\Activation\ActivationAsset\Model\ActivationAsset;
use App\Domain\Activation\Model\Activation;
use App\Domain\Activation\Repository\ActivationRepositoryInterface;
use App\Domain\Activation\Request\CreateActivationRequest;
use App\Domain\Asset\Repository\AssetRepositoryInterface;
use App\Domain\Core\Handler\CreateHandler;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;
use App\Domain\Service\AssetOptimizer\AssetOptimizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Activation|null run(SaveRequest $request)
 */
class CreateActivationHandler
    extends CreateHandler
{
    public function __construct(ValidatorInterface $validator,
        private readonly ActivationRepositoryInterface $repository,
        private readonly AssetRepositoryInterface $assetRepository,
        private readonly AssetOptimizerInterface $assetOptimizer)
    {
        parent::__construct($validator);
    }

    /**
     * @param CreateActivationRequest $request
     * @return Activation|null
     */
    public function handle(CreateActivationRequest $request): ?Activation
    {
        return $this->run($request);
    }

    /**
     * @param CreateActivationRequest $request
     * @return DomainModelInterface
     */
    protected function createModel(SaveRequest $request): DomainModelInterface
    {
        return new Activation($request->getVolume(), $request->getDate());
    }

    protected function completeModel(DomainModelInterface &$model, SaveRequest $request): void
    {
        // No additional attributes to set, all required attributes are set in the construct
    }

    /**
     * @param Activation $model
     * @param CreateActivationRequest $request
     * @return bool
     */
    protected function save(DomainModelInterface &$model, SaveRequest $request): bool
    {
        // Get available assets for the activation date
        $assets = $this->assetRepository->findByAvailabilityDate($request->getDate());
        if (empty($assets)) {
            // No assets available for the activation date, cannot proceed
            $this->addError('No assets available for the activation date');
            return false;
        }

        // ActivationAssets collection
        $response = $this->assetOptimizer->optimize($request->getVolume(), $assets);
        if (!$response->isUsable()) {
            $this->addError('Not enough available assets to fulfill the activation volume');
            return false;
        }

        foreach($response->getAssets() as $asset) {
            $activationAsset = new ActivationAsset();
            $activationAsset->setAsset($asset);

            $model->addActivationAsset($activationAsset);
        }

        return $this->repository->save($model);
    }
}
