<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(title: 'HistoryDto')]
class HistoryDto
{
    public function __construct(
        public int $questId,
        #[Assert\DateTime]
        public DateTimeImmutable $completionDate
    ) {
    }
}
