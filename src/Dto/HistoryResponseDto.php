<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(title: 'HistoryResponseModel')]
class HistoryResponseDto
{
    /**
     * @param HistoryDto[] $histories
     */
    public function __construct(
        #[Assert\GreaterThanOrEqual(0)]
        public int $balance,
        public array $histories,
    ) {
    }

    public static function from(User $user): HistoryResponseDto
    {
        $balance = $user->getBalance();
        $histories = [];
        foreach ($user->getHistory() as $history) {
            $histories[] = new HistoryDto($history->getQuestId(), $history->getCompletionDate());
        }

        return new HistoryResponseDto($balance, $histories);
    }
}
