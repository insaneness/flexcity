<?php

declare(strict_types=1);

namespace App\Controller\Core;

use App\Domain\Core\Handler\SaveHandler;
use App\Domain\Core\Model\AbstractDomainModel;
use App\Domain\Core\Model\DomainModelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Context\Normalizer\DateTimeNormalizerContextBuilder;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class JsonController
    extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    protected function handleErrors(SaveHandler $handler): JsonResponse
    {
        return $this->json([
            'success' => false,
            'errors' => $handler->isValid() ? null : $handler->getErrors(),
        ], Response::HTTP_BAD_REQUEST);
    }

    protected function handleModel(DomainModelInterface $model): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withContext((new DateTimeNormalizerContextBuilder())->withFormat('d-m-Y'))
            ->withGroups([AbstractDomainModel::GROUP_READ])
            ->toArray();

        $test = $this->serializer->normalize($model, 'json', $context);

        return $this->json([
            'success' => true,
            'data' => $this->serializer->normalize($model, 'json', $context),
        ], Response::HTTP_OK);
    }

    protected function getJsonParam(Request $request,
        string $key,
        $default = null)
    {
        static $data = null;

        if ($data === null) {
            $content = $request->getContent();
            $data = json_decode($content, true) ?: [];
        }

        return $data[$key] ?? $default;
    }
}
