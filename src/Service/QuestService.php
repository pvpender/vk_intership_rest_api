<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\QuestRequestDto;
use App\Dto\QuestResponseDto;
use App\Dto\UserRequestDto;
use App\Entity\Quest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class QuestService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function createQuest(QuestRequestDto $questRequestDto): void
    {
        $quest = new Quest();
        $quest
            ->setName($questRequestDto->name)
            ->setCost($questRequestDto->cost);
        $this->entityManager->persist($quest);
        $this->entityManager->flush();
    }

    public function getQuest(int $id): ?QuestResponseDto
    {
        $quest = $this->entityManager->getRepository(Quest::class)->find($id);
        if (!$quest)
            return null;
        return new QuestResponseDto(
            $quest->getId(),
            $quest->getName(),
            $quest->getCost()
        );
    }

}

