<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Entities;

use Carbon\CarbonImmutable;

final readonly class RankedTitle
{
    public const string UNIQUE_KEY_SEPARATOR = "\x1F";

    /** @param ?array<string, mixed> $metadata */
    private function __construct(
        public ?int $id,
        public RankingId $rankingId,
        public CarbonImmutable $storedAt,
        public Rank $rank,
        public string $title,
        public ?array $metadata,
    ) {}

    /** @param ?array<string, mixed> $metadata */
    public static function create(
        int $rankingId,
        CarbonImmutable $storedAt,
        int $rank,
        string $title,
        ?int $id = null,
        ?array $metadata = null,
    ): self {
        return new self(
            id: $id,
            rankingId: RankingId::of($rankingId),
            storedAt: $storedAt,
            rank: Rank::of($rank),
            title: $title,
            metadata: $metadata,
        );
    }

    public function rankUniqueKey(): string
    {
        return implode(self::UNIQUE_KEY_SEPARATOR, [
            $this->rankingId->value,
            $this->storedAt,
            $this->rank->value,
        ]);
    }

    public function titleUniqueKey(): string
    {
        return implode(self::UNIQUE_KEY_SEPARATOR, [
            $this->rankingId->value,
            $this->storedAt,
            $this->title,
        ]);
    }

    /** @return array{id: ?int, ranking_id: int, stored_at: string, rank: int, title: string, metadata: ?array<string, mixed>} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ranking_id' => $this->rankingId->value,
            'stored_at' => $this->storedAt->toIso8601String(),
            'rank' => $this->rank->value,
            'title' => $this->title,
            'metadata' => $this->metadata,
        ];
    }
}
