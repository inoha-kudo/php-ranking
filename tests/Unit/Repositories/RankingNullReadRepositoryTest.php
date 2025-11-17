<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Repositories;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Repositories\RankingNullReadRepository;
use PHPUnit\Framework\TestCase;

final class RankingNullReadRepositoryTest extends TestCase
{
    public function test_get_all(): void
    {
        $this->assertEquals(
            RankedTitleList::from(),
            new RankingNullReadRepository()->getAll(RankingId::of(RankingId::MIN)),
        );
    }
}
