<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Entities;

use Carbon\CarbonImmutable;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankedTitle;
use Miraiportal\Ranking\Entities\RankingId;
use PHPUnit\Framework\TestCase;

final class RankedTitleTest extends TestCase
{
    private array $rankedTitle;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->rankedTitle = [
            'id' => 1,
            'rankingId' => RankingId::MIN,
            'storedAt' => CarbonImmutable::parse('1970-01-01T00:00:00+00:00'),
            'rank' => Rank::MIN,
            'title' => 'title',
            'metadata' => [
                'description' => 'description',
                'thumbnail' => 'thumbnail',
                'genre' => 'genre',
                'link' => 'link',
            ],
        ];
    }

    public function test_create(): void
    {
        $this->expectNotToPerformAssertions();

        RankedTitle::create(...$this->rankedTitle);
    }

    public function test_values(): void
    {
        $rankedTitle = RankedTitle::create(...$this->rankedTitle);

        $this->assertSame(
            $this->rankedTitle['id'],
            $rankedTitle->id,
        );

        $this->assertEquals(
            RankingId::of($this->rankedTitle['rankingId']),
            $rankedTitle->rankingId,
        );

        $this->assertSame(
            $this->rankedTitle['storedAt'],
            $rankedTitle->storedAt,
        );

        $this->assertEquals(
            Rank::of($this->rankedTitle['rank']),
            $rankedTitle->rank,
        );

        $this->assertSame(
            $this->rankedTitle['title'],
            $rankedTitle->title,
        );

        $this->assertSame(
            $this->rankedTitle['metadata'],
            $rankedTitle->metadata,
        );
    }

    public function test_unique_keys(): void
    {
        $rankedTitle = RankedTitle::create(...$this->rankedTitle);

        $this->assertSame(
            implode(RankedTitle::UNIQUE_KEY_SEPARATOR, [
                $this->rankedTitle['rankingId'],
                $this->rankedTitle['storedAt'],
                $this->rankedTitle['rank'],
            ]),
            $rankedTitle->rankUniqueKey(),
        );

        $this->assertSame(
            implode(RankedTitle::UNIQUE_KEY_SEPARATOR, [
                $this->rankedTitle['rankingId'],
                $this->rankedTitle['storedAt'],
                $this->rankedTitle['title'],
            ]),
            $rankedTitle->titleUniqueKey(),
        );
    }

    public function test_to_array(): void
    {
        $this->assertSame(
            [
                'id' => $this->rankedTitle['id'],
                'ranking_id' => $this->rankedTitle['rankingId'],
                'stored_at' => $this->rankedTitle['storedAt']->toIso8601String(),
                'rank' => $this->rankedTitle['rank'],
                'title' => $this->rankedTitle['title'],
                'metadata' => $this->rankedTitle['metadata'],
            ],
            RankedTitle::create(...$this->rankedTitle)->toArray(),
        );
    }
}
