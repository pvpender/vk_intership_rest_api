<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
#[ORM\Table('quests')]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    #[Assert\Length(min: 1, max: 120)]
    private ?string $name = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): Quest
    {
        $this->name = $name;
        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): Quest
    {
        $this->cost = $cost;
        return $this;
    }

}
