<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserRequestDto;
use App\Dto\UserResponseDto;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[OA\Tag('User')]
class UserController
{
    /**
     * Create user
     */
    #[OA\Response(response: 200, description: 'Successful operation')]
    #[Route('/user', methods: ['Post'])]
    public function createUser(
        #[OA\RequestBody(description: 'User data')]
        #[MapRequestPayload]
        UserRequestDto $userRequestDto,
        UserService $service
    ): Response {
        $service->createUser($userRequestDto);

        return new JsonResponse('Success', 200);
    }

    /**
     * Get user by id
     */
    #[OA\Response(response: 200, description: 'User object', content: new Model(type: UserResponseDto::class))]
    #[OA\PathParameter(name: 'id', description: 'User id', schema: new OA\Schema(type: 'integer'))]
    #[Route('/user/{id}', methods: ['Get'])]
    public function getUser(
        int $id,
        UserService $service,
        SerializerInterface $serializer
    ): Response {
        return JsonResponse::fromJsonString($serializer->serialize($service->getUser($id), 'json'));
    }
}
