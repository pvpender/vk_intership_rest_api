<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(title: 'QuestRequestModel')]
class QuestRequestDto
{
    public function __construct(
        #[Assert\Length(min: 1, max: 120)]
        public string $name,
        #[Assert\GreaterThanOrEqual(0)]
        public int $cost,
        public bool $repeatable
    ) {
    }
}
