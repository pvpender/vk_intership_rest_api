<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
use App\Service\QuestService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
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
                    value: [
                        'message' => 'Success',
                        'quest' => new QuestResponseDto(1, 'test', 10, false),
                    ]
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
    #[Route('/quest/{id}', requirements: ['id' => '\d+'], methods: ['Get'])]
    public function getQuest(
        int $id,
        QuestService $service,
        SerializerInterface $serializer
    ): Response {
        $quest = $service->getQuest($id);
        if (!$quest) {
            return new JsonResponse(['message' => "Quest with id={$id} not found"], 404);
        }

        return new JsonResponse(['message' => 'Success', 'quest' => $quest]);
    }

    /**
     * Update quest
     */
    #[OA\Response(response: 'default', description: 'Successful operation')]
    #[OA\PathParameter(name: 'id', description: 'Quest id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/quest/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
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
    #[Route('/quest/{id}', requirements: ['id' => '\d+'], methods: ['Delete'])]
    public function deleteUser(
        int $id,
        QuestService $service
    ): Response {
        if (is_null($service->deleteQuest($id))) {
            return new JsonResponse(['message' => "Quest with id={$id} not found"], 404);
        }

        return new JsonResponse(['message' => 'Success'], 200);
    }

    /**
     * Get all quest
     */
    #[OA\Response(
        response: 200,
        description: 'Quest objects',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'Success',
                    value: ['
                        message' => 'Success',
                        'quest' => [new QuestResponseDto(1, 'test', 10, false)],
                    ]
                )]
        )
    )]
    #[Route('/quest/all', methods: ['Get'])]
    public function getAllQuests(
        QuestService $service
    ): Response {
        $quests = $service->getAllQuests();

        return new JsonResponse(['message' => 'Success', 'quests' => $quests], 200);
    }

    /**
     * Signals that quest is completed
     */
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'success',
                    value: ['message' => 'Success']
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Successful operation',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['Quest with id=1 is already complete by user with id=1']
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'User or quest not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'Invalid user or quest id']
                ),
            ]
        )
    )]
    #[OA\QueryParameter(name: 'userId', description: 'Id of user who complete the quest')]
    #[OA\QueryParameter(name: 'questId', description: 'Id of completed quest')]
    #[Route('/quest/complete', methods: ['POST'])]
    public function addCompletedQuest(
        #[MapQueryParameter]
        int $userId,
        #[MapQueryParameter]
        int $questId,
        QuestService $service,
    ): Response {
        if (is_null($service->addCompletedQuest($userId, $questId))) {
            return new JsonResponse(['message' => 'Invalid user or quest id'], 404);
        }

        return new JsonResponse(['message' => 'Success'], 200);
    }
}
