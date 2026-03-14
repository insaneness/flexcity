<?php

declare(strict_types=1);

namespace App\Controller\Activation;

use App\Controller\Core\JsonController;
use App\Domain\Activation\Handler\CreateActivationHandler;
use App\Domain\Activation\Handler\DeleteActivationHandler;
use App\Domain\Activation\Handler\UpdateActivationHandler;
use App\Domain\Activation\Model\Activation;
use App\Domain\Activation\Request\CreateActivationRequest;
use App\Domain\Activation\Request\DeleteActivationRequest;
use App\Domain\Activation\Request\UpdateActivationRequest;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class ActivationController
    extends JsonController
{
    #[Route('/activation', name: 'create_activation', methods: ['POST'])]
    public function create(Request $request,
        CreateActivationHandler $createActivationHandler): JsonResponse
    {
        $date = $this->getJsonParam($request, 'date');
        if (!is_null($date)) {
            $date = DateTime::createFromFormat('d-m-Y', $date);
            if (!$date) {
                return $this->json(['error' => 'Invalid date format, expected d-m-Y'], Response::HTTP_BAD_REQUEST);
            }
            $date->setTime(0, 0, 0);
        }
        $volume = (int)$this->getJsonParam($request, 'volume');

        $createRequest = new CreateActivationRequest();
        $createRequest->setDate($date);
        $createRequest->setVolume($volume);

        $activation = $createActivationHandler->handle($createRequest);
        if (is_null($activation)) {
            return $this->handleErrors($createActivationHandler);
        }

        // Should send this but it is asked to only return the best assets list for activation volume
        // return $this->handleModel($activation);

        $response = ['success' => true, 'assets' => []];
        foreach($activation->getActivationAssets() as $activationAsset) {
            $asset = $activationAsset->getAsset();
            $response['assets'][] = [
                'name' => $asset->getName(),
                'code' => $asset->getCode(),
                'activation_cost' => $asset->getActivationCost(),
                'volume' => $asset->getVolume(),
            ];
        }

        return $this->json($response, Response::HTTP_OK);
    }

    #[Route('/activation/{uuid}', name: 'get_activation', methods: ['GET'])]
    public function get(#[MapEntity(mapping: ['uuid' => 'uuid'])] Activation $activation,
        Request $request): JsonResponse
    {
        return $this->handleModel($activation);
    }

    #[Route('/activation/{uuid}', name: 'update_activation', methods: ['PATCH'])]
    public function update(#[MapEntity(mapping: ['uuid' => 'uuid'])] Activation $activation,
        Request $request,
        UpdateActivationHandler $updateActivationHandler): JsonResponse
    {
        $date = $request->request->get('date');
        $volume = (int)$request->request->get('volume');

        $updateRequest = new UpdateActivationRequest($activation);
        if (!is_null($date)) {
            $date = new \DateTime($date);
            $date->setTime(0,0,0);
            $updateRequest->setDate($date);
        }
        if (!is_null($volume)) {
            $updateRequest->setVolume($volume);
        }

        $activation = $updateActivationHandler->handle($updateRequest);
        if (is_null($activation)) {
            return $this->handleErrors($updateActivationHandler);
        }

        return $this->handleModel($activation);
    }

    #[Route('/activation/{uuid}', name: 'delete_activation', methods: ['DELETE'])]
    public function delete(#[MapEntity(mapping: ['uuid' => 'uuid'])] Activation $activation,
        DeleteActivationHandler $deleteActivationHandler): JsonResponse
    {
        $deleteRequest = new DeleteActivationRequest($activation);
        $result = $deleteActivationHandler->handle($deleteRequest);

        if (!$result) {
            return $this->json(['success' => false, 'error' => 'Activation could not be deleted'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['success' => true], Response::HTTP_OK);
    }
}
