<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Entities;

final readonly class RankedTitleList
{
    public const string EXCEPTION_MESSAGE_NON_UNIQUE_RANKS = 'The provided ranked titles must have unique ranks per (rankingId, storedAt).';

    public const string EXCEPTION_MESSAGE_NON_UNIQUE_TITLES = 'The provided ranked titles must have unique titles per (rankingId, storedAt).';

    /** @var list<RankedTitle> */
    private array $rankedTitles;

    /** @no-named-arguments */
    private function __construct(
        RankedTitle ...$rankedTitles,
    ) {
        if (! self::hasUniqueRanks(...$rankedTitles)) {
            throw new \DomainException(self::EXCEPTION_MESSAGE_NON_UNIQUE_RANKS);
        }
        if (! self::hasUniqueTitles(...$rankedTitles)) {
            throw new \DomainException(self::EXCEPTION_MESSAGE_NON_UNIQUE_TITLES);
        }

        $this->rankedTitles = $rankedTitles;
    }

    /** @no-named-arguments */
    public static function from(RankedTitle ...$rankedTitles): self
    {
        return new self(...$rankedTitles);
    }

    public function add(self $other): self
    {
        return self::from(...$this->rankedTitles, ...$other->all());
    }

    /** @return list<RankedTitle> */
    public function all(): array
    {
        return $this->rankedTitles;
    }

    public function count(): int
    {
        return count($this->rankedTitles);
    }

    public function first(): ?RankedTitle
    {
        return array_first($this->rankedTitles);
    }

    /**
     * @template T
     *
     * @param  callable(RankedTitle): T  $callback
     * @return list<T>
     */
    public function map(callable $callback): array
    {
        return array_map($callback, $this->rankedTitles);
    }

    /** @return list<array{id: ?int, ranking_id: int, stored_at: string, rank: int, title: string, metadata: ?array<string, mixed>}> */
    public function toArray(): array
    {
        return array_map(
            fn (RankedTitle $rankedTitle) => $rankedTitle->toArray(),
            $this->rankedTitles,
        );
    }

    private static function hasUniqueRanks(RankedTitle ...$rankedTitles): bool
    {
        return self::hasUniqueBy(fn (RankedTitle $rankedTitle) => $rankedTitle->rankUniqueKey(), ...$rankedTitles);
    }

    private static function hasUniqueTitles(RankedTitle ...$rankedTitles): bool
    {
        return self::hasUniqueBy(fn (RankedTitle $rankedTitle) => $rankedTitle->titleUniqueKey(), ...$rankedTitles);
    }

    private static function hasUniqueBy(callable $keySelector, RankedTitle ...$rankedTitles): bool
    {
        return count(array_unique(array_map($keySelector, $rankedTitles))) === count($rankedTitles);
    }
}
