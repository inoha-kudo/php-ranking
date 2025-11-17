<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Repositories;

use Miraiportal\Ranking\Entities\RankedTitleList;

interface RankingWriteRepository
{
    public function add(RankedTitleList $rankedTitleList): void;
}
