<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\QuestRequestDto;
use App\Service\QuestService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[OA\Tag('Quest')]
class QuestController
{
    /**
     * Create quest
     */
    #[OA\Response(response: 200, description: 'Successful operation')]
    #[Route('/quest', methods: ['Post'])]
    public function createQuest(
        #[OA\RequestBody(description: 'Quest data')]
        #[MapRequestPayload]
        QuestRequestDto $questRequestDto,
        QuestService $questService
    ): Response {
        $questService->createQuest($questRequestDto);

        return new JsonResponse('Success', 200);
    }

    /**
     * Get quest by id
     */
    #[OA\Response(response: 200, description: 'Quest object', content: new Model(type: QuestRequestDto::class))]
    #[OA\PathParameter(name: 'id', description: 'Quest id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/quest/{id}', methods: ['Get'])]
    public function getQuest(
        int $id,
        QuestService $service,
        SerializerInterface $serializer
    ): Response {
        return JsonResponse::fromJsonString($serializer->serialize($service->getQuest($id), 'json'));
    }
}
