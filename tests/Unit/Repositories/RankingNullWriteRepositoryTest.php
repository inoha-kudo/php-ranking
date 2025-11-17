<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Repositories;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Repositories\RankingNullWriteRepository;
use PHPUnit\Framework\TestCase;

final class RankingNullWriteRepositoryTest extends TestCase
{
    public function test_add(): void
    {
        $this->expectNotToPerformAssertions();

        new RankingNullWriteRepository()->add(RankedTitleList::from());
    }
}
