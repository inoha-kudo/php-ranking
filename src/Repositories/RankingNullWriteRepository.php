<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Repositories;

use Miraiportal\Ranking\Contracts\RankingWriteRepository;
use Miraiportal\Ranking\Entities\RankedTitleList;

final readonly class RankingNullWriteRepository implements RankingWriteRepository
{
    #[\Override]
    public function add(RankedTitleList $rankedTitleList): void {}
}
