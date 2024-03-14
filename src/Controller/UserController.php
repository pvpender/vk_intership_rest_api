<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\QuestRequestDto;
use App\Dto\UserRequestDto;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class UserController
{
    #[Route('/user', methods: ['Post'])]
    public function createUser(
        #[OA\RequestBody(description: "User")]
        #[MapRequestPayload]
        UserRequestDto $userRequestDto,
        UserService $service
    ): Response
    {
        $service->createUser($userRequestDto);
        return new JsonResponse('Success', 200);
    }

    #[Route('/user/{id}', methods: ['Get'])]
    public function getUser(
        int $id,
        UserService $service,
        SerializerInterface $serializer
    ): Response
    {
        return JsonResponse::fromJsonString($serializer->serialize($service->getUser($id), 'json'));
    }

}