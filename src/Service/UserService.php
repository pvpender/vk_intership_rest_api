<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\HistoryResponseDto;
use App\Dto\UserRequestDto;
use App\Dto\UserResponseDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createUser(UserRequestDto $userRequestDto): int
    {
        $user = new User();
        $user
            ->setName($userRequestDto->name)
            ->setBalance($userRequestDto->balance);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
    }

    public function getUser(int $id): ?UserResponseDto
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return null;
        }

        return new UserResponseDto(
            $user->getId(),
            $user->getName(),
            $user->getBalance()
        );
    }

    public function updateUser(int $id, UserRequestDto $userRequestDto): void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return;
        }

        $user
            ->setName($userRequestDto->name)
            ->setBalance($userRequestDto->balance);
        $this->entityManager->flush();
    }

    public function deleteUser(int $id): ?int
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return null;
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return 1;
    }

    public function getUserHistory(int $id): ?HistoryResponseDto
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return null;
        }

        return HistoryResponseDto::from($user);
    }

    /**
     * @return UserResponseDto[]
     */
    public function getAllUsers(): array
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $usersDto = [];
        foreach ($users as $user) {
            $usersDto[] = new UserResponseDto($user->getId(), $user->getName(), $user->getBalance());
        }

        return $usersDto;
    }
}
