<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
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
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        content: new OA\JsonContent(
            [
                new OA\Examples(example: 'integer', summary: 'Creation', value: ['message' => 'Success', 'id' => 1]),
            ]
        )
    )]
    #[Route('/quest', methods: ['Post'])]
    public function createQuest(
        #[OA\RequestBody(description: 'Quest data')]
        #[MapRequestPayload]
        QuestRequestDto $questRequestDto,
        QuestService $questService
    ): Response {
        $id = $questService->createQuest($questRequestDto);

        return new JsonResponse(['message' => 'Success', 'id' => $id], 200);
    }

    /**
     * Get quest by id
     */
    #[OA\Response(
        response: 200,
        description: 'Quest object',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'Success',
                    value: ['message' => 'Success', 'quest' => new QuestResponseDto(1, 'test', 10)]
                )]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Quest not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'Quest with id=0 not found']
                ),
            ]
        )
    )]
    #[OA\PathParameter(name: 'id', description: 'Quest id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/quest/{id}', methods: ['Get'])]
    public function getQuest(
        int $id,
        QuestService $service,
        SerializerInterface $serializer
    ): Response {
        $quest = $service->getQuest($id);
        if (is_null($quest)){
            return new JsonResponse(['message' => "Quest with id={$id} not found"], 404);
        }
        return new JsonResponse(['message' => 'Success', 'quest' => $quest]);
    }

    /**
     * Update quest
     */
    #[OA\Response(response: 'default', description: 'Successful operation')]
    #[OA\PathParameter(name: 'id', description: 'Quest id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/quest/{id}', methods: ['PUT'])]
    public function updateUser(
        int $id,
        #[OA\RequestBody(description: 'User data')]
        #[MapRequestPayload]
        QuestRequestDto $questRequestDto,
        QuestService $service,
    ): Response {
        $service->updateQuest($id, $questRequestDto);

        return new JsonResponse(['message' => 'Success'], 200);
    }

    /**
     * Delete quest
     */
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'Success',
                    value: ['message' => 'Success']
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Quest not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'Quest with id=0 not found']
                ),
            ]
        )
    )]
    #[OA\PathParameter(name: 'id', description: 'Quest id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/quest/{id}', methods: ['Delete'])]
    public function deleteUser(
        int $id,
        QuestService $service
    ): Response {
        if (is_null($service->deleteQuest($id))) {
            return new JsonResponse(['message' => "Quest with id={$id} not found"], 404);
        }

        return new JsonResponse(['message' => 'Success'], 200);
    }
}
