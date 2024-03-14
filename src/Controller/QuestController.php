<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
use App\Dto\UserRequestDto;
use App\Service\QuestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class QuestController
{
    #[Route('/quest', methods: ['Post'])]
    public function createQuest(
        #[OA\RequestBody(description: "Quest")]
        #[MapRequestPayload]
        QuestRequestDto $questRequestDto,

        QuestService $questService
    ): Response
    {
        $questService->createQuest($questRequestDto);
        return new JsonResponse('Success', 200);
    }

    #[Route('/quest/{id}', methods: ['Get'])]
    public function getQuest(
        int $id,
        QuestService $service,
        SerializerInterface $serializer
    ): Response
    {
        return JsonResponse::fromJsonString($serializer->serialize($service->getQuest($id), 'json'));
    }

}
