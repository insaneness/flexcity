<?php

namespace App\Domain\Activation\Handler;

use App\Domain\Activation\Model\Activation;
use App\Domain\Activation\Repository\ActivationRepositoryInterface;
use App\Domain\Activation\Request\UpdateActivationRequest;
use App\Domain\Core\Handler\UpdateHandler;
use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Activation|null run(SaveRequest $request)
 */
class UpdateActivationHandler
    extends UpdateHandler
{
    public function __construct(ValidatorInterface $validator,
        private readonly ActivationRepositoryInterface $repository)
    {
        parent::__construct($validator);
    }

    public function handle(UpdateActivationRequest $request): ?Activation
    {
        return $this->run($request);
    }

    /**
     * @param Activation $model
     * @param UpdateActivationRequest $request
     * @return void
     */
    protected function completeModel(DomainModelInterface &$model, SaveRequest $request): void
    {
        if (!is_null($request->getDate())) {
            $model->setDate($request->getDate());
        }
        if (!is_null($request->getVolume())) {
            $model->setVolume($request->getVolume());
        }
    }

    /**
     * @param Activation $model
     * @param UpdateActivationRequest $request
     * @return bool
     */
    protected function save(DomainModelInterface &$model, SaveRequest $request): bool
    {
        return $this->repository->save($model);
    }
}
