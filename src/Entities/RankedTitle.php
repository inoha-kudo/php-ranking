<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Entities;

use Carbon\CarbonImmutable;

final readonly class RankedTitle
{
    public const string UNIQUE_KEY_SEPARATOR = "\x1F";

    /** @param ?array<string, mixed> $metadata */
    private function __construct(
        private ?int $id,
        private RankingId $rankingId,
        private CarbonImmutable $storedAt,
        private Rank $rank,
        private string $title,
        private ?array $metadata,
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

    public function id(): ?int
    {
        return $this->id;
    }

    public function rankingId(): int
    {
        return $this->rankingId->value();
    }

    public function storedAt(): CarbonImmutable
    {
        return $this->storedAt;
    }

    public function rank(): int
    {
        return $this->rank->value();
    }

    public function title(): string
    {
        return $this->title;
    }

    /** @return ?array<string, mixed> */
    public function metadata(): ?array
    {
        return $this->metadata;
    }

    public function rankUniqueKey(): string
    {
        return implode(self::UNIQUE_KEY_SEPARATOR, [
            $this->rankingId(),
            $this->storedAt(),
            $this->rank(),
        ]);
    }

    public function titleUniqueKey(): string
    {
        return implode(self::UNIQUE_KEY_SEPARATOR, [
            $this->rankingId(),
            $this->storedAt(),
            $this->title(),
        ]);
    }

    /** @return array{id: ?int, ranking_id: int, stored_at: string, rank: int, title: string, metadata: ?array<string, mixed>} */
    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'ranking_id' => $this->rankingId(),
            'stored_at' => $this->storedAt()->toIso8601String(),
            'rank' => $this->rank(),
            'title' => $this->title(),
            'metadata' => $this->metadata(),
        ];
    }
}
