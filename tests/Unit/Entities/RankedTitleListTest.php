<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Entities;

use Carbon\CarbonImmutable;
use DomainException;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankedTitle;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use PHPUnit\Framework\TestCase;

final class RankedTitleListTest extends TestCase
{
    private array $rankedTitles;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $rankingId = RankingId::MIN;
        $storedAt = CarbonImmutable::parse('1970-01-01T00:00:00+00:00');
        $rank = Rank::MIN;

        $this->rankedTitles = [
            RankedTitle::create($rankingId, $storedAt, $rank, 'title_'.$rank),
            RankedTitle::create($rankingId, $storedAt, $rank + 1, 'title_'.($rank + 1)),
        ];
    }

    public function test_from_with_empty_ranked_titles(): void
    {
        $this->expectNotToPerformAssertions();

        RankedTitleList::from();
    }

    public function test_from_with_ranked_titles_having_non_unique_ranks(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(RankedTitleList::EXCEPTION_MESSAGE_NON_UNIQUE_RANKS);

        RankedTitleList::from(
            RankedTitle::create(
                $this->rankedTitles[0]->rankingId->value,
                $this->rankedTitles[0]->storedAt,
                $this->rankedTitles[0]->rank->value,
                $this->rankedTitles[0]->title,
            ),
            RankedTitle::create(
                $this->rankedTitles[1]->rankingId->value,
                $this->rankedTitles[1]->storedAt,
                $this->rankedTitles[0]->rank->value,
                $this->rankedTitles[1]->title,
            ),
        );
    }

    public function test_from_with_ranked_titles_having_non_unique_titles(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(RankedTitleList::EXCEPTION_MESSAGE_NON_UNIQUE_TITLES);

        RankedTitleList::from(
            RankedTitle::create(
                $this->rankedTitles[0]->rankingId->value,
                $this->rankedTitles[0]->storedAt,
                $this->rankedTitles[0]->rank->value,
                $this->rankedTitles[0]->title,
            ),
            RankedTitle::create(
                $this->rankedTitles[1]->rankingId->value,
                $this->rankedTitles[1]->storedAt,
                $this->rankedTitles[1]->rank->value,
                $this->rankedTitles[0]->title,
            ),
        );
    }

    public function test_add(): void
    {
        $this->assertEquals(
            RankedTitleList::from(...$this->rankedTitles),
            RankedTitleList::from()->add(RankedTitleList::from(...$this->rankedTitles)),
        );
    }

    public function test_all(): void
    {
        $this->assertSame(
            $this->rankedTitles,
            RankedTitleList::from(...$this->rankedTitles)->all(),
        );
    }

    public function test_count(): void
    {
        $this->assertSame(
            count($this->rankedTitles),
            RankedTitleList::from(...$this->rankedTitles)->count(),
        );

        $this->assertSame(
            0,
            RankedTitleList::from()->count(),
        );
    }

    public function test_first(): void
    {
        $this->assertSame(
            $this->rankedTitles[0],
            RankedTitleList::from(...$this->rankedTitles)->first(),
        );

        $this->assertNull(RankedTitleList::from()->first());
    }

    public function test_map(): void
    {
        $this->assertSame(
            [
                $this->rankedTitles[0]->title,
                $this->rankedTitles[1]->title,
            ],
            RankedTitleList::from(...$this->rankedTitles)->map(
                fn (RankedTitle $rankedTitle) => $rankedTitle->title,
            ),
        );
    }

    public function test_to_array(): void
    {
        $this->assertSame(
            [
                [
                    'id' => null,
                    'ranking_id' => $this->rankedTitles[0]->rankingId->value,
                    'stored_at' => $this->rankedTitles[0]->storedAt->toIso8601String(),
                    'rank' => $this->rankedTitles[0]->rank->value,
                    'title' => $this->rankedTitles[0]->title,
                    'metadata' => null,
                ],
                [
                    'id' => null,
                    'ranking_id' => $this->rankedTitles[1]->rankingId->value,
                    'stored_at' => $this->rankedTitles[1]->storedAt->toIso8601String(),
                    'rank' => $this->rankedTitles[1]->rank->value,
                    'title' => $this->rankedTitles[1]->title,
                    'metadata' => null,
                ],
            ],
            RankedTitleList::from(...$this->rankedTitles)->toArray(),
        );
    }
}
