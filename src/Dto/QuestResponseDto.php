<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class QuestResponseDto
{
    public function __construct(
        #[Assert\GreaterThan(0)]
        public int $id,
        #[Assert\Length(min: 1, max: 120)]
        public string $name,
        #[Assert\GreaterThanOrEqual(0)]
        public int $cost
    )
    {

    }
}

