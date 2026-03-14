<?php

namespace App\Domain\Core\Handler;

use App\Domain\Core\Model\DomainModelInterface;
use App\Domain\Core\Request\SaveRequest;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class SaveHandler
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected ConstraintViolationListInterface $errors;

    public function __construct(private readonly ValidatorInterface $validator)
    {
        $this->resetErrors();
    }

    public function run(SaveRequest $request): ?DomainModelInterface
    {
        $this->resetErrors();

        $model = $this->getModelFromRequest($request);
        $this->completeModel($model, $request);

        if (!$this->validateObject($model)) {
            return null;
        }

        $saveResult = $this->save($model, $request);

        if (!$saveResult) {
            return null;
        }

        return $model;
    }

    protected abstract function completeModel(DomainModelInterface &$model, SaveRequest $request): void;
    protected abstract function getModelFromRequest(SaveRequest $request): DomainModelInterface;
    protected abstract function save(DomainModelInterface &$model, SaveRequest $request): bool;

    protected function resetErrors(): void
    {
        $this->errors = new ConstraintViolationList();
    }

    public function isValid(): bool
    {
        return count($this->errors) == 0;
    }

    protected function validateObject($object): bool
    {
        $this->setErrors($this->validator->validate($object));
        return $this->isValid();
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function setErrors(ConstraintViolationListInterface $errors): void
    {
        $this->errors = $errors;
    }

    public function addError(string $message): void
    {
        $violation = new ConstraintViolation($message, null, [], null, null, null);
        $this->errors->add($violation);
    }
}
