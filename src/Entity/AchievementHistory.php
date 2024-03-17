<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AchievementHistoryRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AchievementHistoryRepository::class)]
#[ORM\Table('achievement_history')]
class AchievementHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\GreaterThan(0)]
    private ?int $userId = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\GreaterThan(0)]
    private ?int $questId = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\DateTime]
    private ?DateTimeImmutable $completionDate;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Quest::class)]
    #[ORM\JoinColumn(name: 'quest_id', referencedColumnName: 'id')]
    private ?Quest $quest = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getQuestId(): int
    {
        return $this->questId;
    }

    public function setQuestId(int $questId): self
    {
        $this->questId = $questId;

        return $this;
    }

    public function getCompletionDate(): DateTimeImmutable
    {
        return $this->completionDate;
    }

    public function setCompletionDate(DateTimeImmutable $date): self
    {
        $this->completionDate = $date;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuest(): Quest
    {
        return $this->quest;
    }

    public function setQuest(Quest $quest): self
    {
        $this->quest = $quest;

        return $this;
    }
}
