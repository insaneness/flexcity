<?php

namespace App\Controller\Activation;

use App\Controller\Core\JsonController;
use App\Domain\Asset\Handler\CreateAssetHandler;
use App\Domain\Asset\Handler\DeleteAssetHandler;
use App\Domain\Asset\Handler\UpdateAssetHandler;
use App\Domain\Asset\Model\Asset;
use App\Domain\Asset\Request\CreateAssetRequest;
use App\Domain\Asset\Request\DeleteAssetRequest;
use App\Domain\Asset\Request\UpdateAssetRequest;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AssetController
    extends JsonController
{
    #[Route('/asset', name: 'create_asset', methods: ['POST'])]
    public function create(Request $request,
        CreateAssetHandler $createAssetHandler): JsonResponse
    {
        $createRequest = new CreateAssetRequest();
        $createRequest->setName((string)$this->getJsonParam($request, 'name'));
        $createRequest->setCode((string)$this->getJsonParam($request, 'code'));
        $createRequest->setVolume((int)$this->getJsonParam($request, 'volume'));
        $createRequest->setActivationCost((float)$this->getJsonParam($request, 'activation_cost'));
        $createRequest->setRAvailabilities((array)$this->getJsonParam($request, 'availability'));

        $activation = $createAssetHandler->handle($createRequest);
        if (is_null($activation)) {
            return $this->handleErrors($createAssetHandler);
        }

        return $this->handleModel($activation);
    }

    #[Route('/asset/{uuid}', name: 'get_asset', methods: ['GET'])]
    public function get(#[MapEntity(mapping: ['uuid' => 'uuid'])] Asset $asset): JsonResponse
    {
        return $this->handleModel($asset);
    }

    #[Route('/asset/{uuid}', name: 'update_asset', methods: ['PATCH'])]
    public function update(#[MapEntity(mapping: ['uuid' => 'uuid'])] Asset $asset,
        Request $request,
        UpdateAssetHandler $updateAssetHandler): JsonResponse
    {
        $volume = (int)$this->getJsonParam($request, 'volume');
        $name = (string)$this->getJsonParam($request, 'name');
        $code = (string)$this->getJsonParam($request, 'code');
        $activationCost = (float)$this->getJsonParam($request, 'activation_cost');
        $availabilities = (array)$this->getJsonParam($request, 'availability', []);

        $updateRequest = new UpdateAssetRequest($asset);
        if (!is_null($volume)) {
            $updateRequest->setVolume($volume);
        }
        if (!is_null($name)) {
            $updateRequest->setName($name);
        }
        if (!is_null($code)) {
            $updateRequest->setCode($code);
        }
        if (!is_null($activationCost)) {
            $updateRequest->setActivationCost($activationCost);
        }
        if (!empty($availabilities)) {
            $updateRequest->setRAvailabilities($availabilities);
        }

        $activation = $updateAssetHandler->handle($updateRequest);
        if (is_null($activation)) {
            return $this->handleErrors($updateAssetHandler);
        }

        return $this->handleModel($activation);
    }

    #[Route('/asset/{uuid}', name: 'delete_asset', methods: ['DELETE'])]
    public function delete(#[MapEntity(mapping: ['uuid' => 'uuid'])] Asset $asset,
        DeleteAssetHandler $deleteAssetHandler): JsonResponse
    {
        $deleteRequest = new DeleteAssetRequest($asset);
        $result = $deleteAssetHandler->handle($deleteRequest);

        if (!$result) {
            return $this->json(['success' => false, 'error' => 'Asset could not be deleted'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['success' => true], Response::HTTP_OK);
    }
}
