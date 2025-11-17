<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Services;

use Carbon\CarbonImmutable;
use Miraiportal\Ranking\Contracts\RankingReadRepository;
use Miraiportal\Ranking\Contracts\RankingWriteRepository;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankedTitle;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Services\RankingService;
use PHPUnit\Framework\TestCase;

final class RankingServiceTest extends TestCase
{
    private RankedTitleList $rankedTitleList;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $rankingId = RankingId::MIN;
        $storedAt = CarbonImmutable::parse('1970-01-01T00:00:00+00:00');
        $rank = Rank::MIN;

        $this->rankedTitleList = RankedTitleList::from(
            RankedTitle::create($rankingId, $storedAt, $rank, 'title_'.$rank),
            RankedTitle::create($rankingId, $storedAt, $rank + 1, 'title_'.($rank + 1)),
        );
    }

    public function test_get_all(): void
    {
        $rankingReadRepositoryMock = $this->createMock(RankingReadRepository::class);

        $rankingId = $this->rankedTitleList->first()->rankingId;
        $params = ['rank' => 1];

        $rankingReadRepositoryMock->expects($this->once())
            ->method('getAll')
            ->with($rankingId, $params)
            ->willReturn($this->rankedTitleList);

        $this->assertSame(
            $this->rankedTitleList,
            new RankingService(
                readRepository: $rankingReadRepositoryMock,
            )->getAll($rankingId, $params),
        );
    }

    public function test_add(): void
    {
        $rankingWriteRepositoryMock = $this->createMock(RankingWriteRepository::class);

        $rankingWriteRepositoryMock->expects($this->once())
            ->method('add')
            ->with($this->rankedTitleList);

        new RankingService(
            writeRepository: $rankingWriteRepositoryMock,
        )->add($this->rankedTitleList);
    }

    public function test_ingest(): void
    {
        $rankingReadRepositoryMock = $this->createMock(RankingReadRepository::class);
        $rankingWriteRepositoryMock = $this->createMock(RankingWriteRepository::class);

        $rankingId = $this->rankedTitleList->first()->rankingId;
        $params = ['rank' => 1];

        $rankingReadRepositoryMock->expects($this->once())
            ->method('getAll')
            ->with($rankingId, $params)
            ->willReturn($this->rankedTitleList);

        $rankingWriteRepositoryMock->expects($this->once())
            ->method('add')
            ->with($this->rankedTitleList);

        new RankingService(
            readRepository: $rankingReadRepositoryMock,
            writeRepository: $rankingWriteRepositoryMock,
        )->ingest($rankingId, $params);
    }
}
