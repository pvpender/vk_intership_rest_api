<?php

declare(strict_types=1);

namespace App\Dto;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class QuestRequestDto
{
    public function __construct(
        #[Groups(["default", "create", "update"])]
        #[Assert\Length(min: 1, max: 120)]
        public string $name,

        #[Groups(["default", "create", "update"])]
        #[Assert\GreaterThanOrEqual(0)]
        public int $cost
    ) {
    }
}
