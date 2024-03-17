<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(title: 'QuestResponseModel')]
class QuestResponseDto
{
    public function __construct(
        #[Assert\GreaterThan(0)]
        public int $id,
        #[Assert\Length(min: 1, max: 120)]
        public string $name,
        #[Assert\GreaterThanOrEqual(0)]
        public int $cost,
        public bool $repeatable
    ) {
    }
}
