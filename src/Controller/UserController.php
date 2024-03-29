<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserRequestDto;
use App\Dto\UserResponseDto;
use App\Entity\User;
use App\Service\UserService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[OA\Tag('User')]
class UserController
{
    /**
     * Create user
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
    #[Route('/user', methods: ['Post'])]
    public function createUser(
        #[OA\RequestBody(description: 'User data')]
        #[MapRequestPayload]
        UserRequestDto $userRequestDto,
        UserService $service
    ): Response {
        $id = $service->createUser($userRequestDto);

        return new JsonResponse(['message' => 'Success', 'id' => $id], 200);
    }

    /**
     * Get user by id
     */
    #[OA\Response(
        response: 200,
        description: 'User object',
        content: new OA\JsonContent(
            [
            new OA\Examples(
                example: 'result',
                summary: 'Success',
                value: ['message' => 'Success', 'user' => new UserResponseDto(1, 'test', 0)]
            )]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'User not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'User with id=0 not found']
                ),
            ]
        )
    )]
    #[OA\PathParameter(name: 'id', description: 'User id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/user/{id}', requirements: ['id' => '\d+'], methods: ['Get'])]
    public function getUser(
        int $id,
        UserService $service,
    ): Response {
        $user = $service->getUser($id);
        if (!$user) {
            return new JsonResponse(
                [
                    'message' => "User with id={$id} not found",
                ],
                404
            );
        }

        return new JsonResponse(
            [
                'message' => 'Success',
                'user' => $service->getUser($id),
            ],
            200
        );
    }

    /**
     * Get all users
     */
    #[OA\Response(
        response: 200,
        description: 'User objects',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'Success',
                    value: ['message' => 'Success', 'users' => [new UserResponseDto(1, 'test', 0)]]
                )]
        )
    )]
    #[Route('/user/all', methods: ['Get'])]
    public function getAllUsers(
        UserService $service
    ): Response {
        $users = $service->getAllUsers();

        return new JsonResponse(['message' => 'Success', 'users' => $users], 200);
    }

    /**
     * Update user
     */
    #[OA\Response(response: 'default', description: 'Successful operation')]
    #[OA\PathParameter(name: 'id', description: 'User id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/user/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateUser(
        int $id,
        #[OA\RequestBody(description: 'User data')]
        #[MapRequestPayload]
        UserRequestDto $userRequestDto,
        UserService $service,
    ): Response {
        $service->updateUser($id, $userRequestDto);

        return new JsonResponse(['message' => 'Success'], 200);
    }

    /**
     * Delete user
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
        description: 'User not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'User with id=0 not found']
                ),
            ]
        )
    )]
    #[OA\PathParameter(name: 'id', description: 'User id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/user/{id}', requirements: ['id' => '\d+'], methods: ['Delete'])]
    public function deleteUser(
        int $id,
        UserService $service
    ): Response {
        if (is_null($service->deleteUser($id))) {
            return new JsonResponse(['message' => "User with id={$id} not found"], 404);
        }

        return new JsonResponse(['message' => 'Success'], 200);
    }

    /**
     * Get user balance and history
     */
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'Success',
                    value: ['message' => 'Success', "balance" => 10, 'histories' => []]
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'User not found',
        content: new OA\JsonContent(
            [
                new OA\Examples(
                    example: 'result',
                    summary: 'error',
                    value: ['message' => 'User with id=0 not found']
                ),
            ]
        )
    )]
    #[OA\PathParameter(name: 'id', description: 'User id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/user/{id}/history', methods: ['Get'])]
    public function getUserHistory(
        int $id,
        UserService $service
    ): Response {
        $history = $service->getUserHistory($id);
        if (!$history) {
            return new JsonResponse(['message' => "User with id={$id} not found"], 404);
        }

        return new JsonResponse(['message' => 'Success', 'history' => $history], 200);
    }
}
