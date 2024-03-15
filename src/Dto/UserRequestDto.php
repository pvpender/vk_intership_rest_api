<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(title: 'UserRequestModel')]
class UserRequestDto
{
    public function __construct(
        #[Groups(['default', 'create', 'update'])]
        #[Assert\Length(min: 1, max: 120)]
        public string $name,
        #[Groups(['default', 'create', 'update'])]
        #[Assert\GreaterThanOrEqual(0)]
        public int $balance
    ) {
    }
}
