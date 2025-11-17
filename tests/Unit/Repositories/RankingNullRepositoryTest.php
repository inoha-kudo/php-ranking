<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Repositories;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Repositories\RankingNullRepository;
use PHPUnit\Framework\TestCase;

final class RankingNullRepositoryTest extends TestCase
{
    private RankingNullRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new RankingNullRepository;
    }

    public function test_get_all(): void
    {
        $this->assertEquals(
            RankedTitleList::from(),
            $this->repository->getAll(RankingId::of(RankingId::MIN)),
        );
    }

    public function test_add(): void
    {
        $this->expectNotToPerformAssertions();

        $this->repository->add(RankedTitleList::from());
    }
}
