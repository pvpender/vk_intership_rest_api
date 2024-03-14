<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\UserRequestDto;
use App\Dto\UserResponseDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\String\u;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function createUser(UserRequestDto $userRequestDto): void
    {
        $user = new User();
        $user
            ->setName($userRequestDto->name)
            ->setBalance($userRequestDto->balance);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getUser(int $id): ?UserResponseDto
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user)
            return null;
        return new UserResponseDto(
            $user->getId(),
            $user->getName(),
            $user->getBalance()
        );
    }

}
