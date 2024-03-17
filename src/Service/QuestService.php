<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
use App\Entity\AchievementHistory;
use App\Entity\Quest;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuestService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createQuest(QuestRequestDto $questRequestDto): int
    {
        $quest = new Quest();
        $quest
            ->setName($questRequestDto->name)
            ->setCost($questRequestDto->cost)
            ->setRepeatable($questRequestDto->repeatable);
        $this->entityManager->persist($quest);
        $this->entityManager->flush();

        return $quest->getId();
    }

    public function getQuest(int $id): ?QuestResponseDto
    {
        $quest = $this->entityManager->getRepository(Quest::class)->find($id);
        if (!$quest) {
            return null;
        }

        return new QuestResponseDto(
            $quest->getId(),
            $quest->getName(),
            $quest->getCost(),
            $quest->getRepeatable()
        );
    }

    public function updateQuest(int $id, QuestRequestDto $questRequestDto): void
    {
        $quest = $this->entityManager->getRepository(Quest::class)->find($id);
        if (!$quest) {
            return;
        }
        $quest
            ->setName($questRequestDto->name)
            ->setCost($questRequestDto->cost)
            ->setRepeatable($questRequestDto->repeatable);
        $this->entityManager->flush();
    }

    public function deleteQuest(int $id): ?int
    {
        $quest = $this->entityManager->getRepository(Quest::class)->find($id);
        if (!$quest) {
            return null;
        }
        $this->entityManager->remove($quest);
        $this->entityManager->flush();

        return 1;
    }

    public function addCompletedQuest(int $userId, int $questId): ?int
    {
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        $quest = $this->entityManager->getRepository(Quest::class)->find($questId);
        if (!$user or !$quest) {
            return null;
        }
        $history = new AchievementHistory();
        $history
            ->setUserId($userId)
            ->setQuestId($questId)
            ->setUser($user)
            ->setQuest($quest)
            ->setCompletionDate(new DateTimeImmutable());
        if ($quest->getRepeatable() === false) {
            foreach ($user->getHistory() as $value) {
                if ($history->getQuestId() === $value->getQuestId()) {
                    throw new HttpException(
                        400,
                        "Quest with id={$questId} is already complete by user with id={$userId}"
                    );
                }
            }
        }
        $user->addHistory($history);
        $user
            ->setBalance($user->getBalance() + $quest->getCost());
        $this->entityManager->flush();

        return 1;
    }

    /**
     * @return QuestResponseDto[]
     */
    public function getAllQuests(): array
    {
        $quests = $this->entityManager->getRepository(Quest::class)->findAll();
        $questsDto = [];
        foreach ($quests as $quest) {
            $questsDto[] = new QuestResponseDto(
                $quest->getId(),
                $quest->getName(),
                $quest->getCost(),
                $quest->getRepeatable()
            );
        }

        return $questsDto;
    }
}
