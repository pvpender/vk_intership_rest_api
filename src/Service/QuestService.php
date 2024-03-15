<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
use App\Entity\Quest;
use Doctrine\ORM\EntityManagerInterface;

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
            ->setCost($questRequestDto->cost);
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
            $quest->getCost()
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
            ->setCost($questRequestDto->cost);
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

}
