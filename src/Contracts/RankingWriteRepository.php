<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Contracts;

use Miraiportal\Ranking\Entities\RankedTitleList;

interface RankingWriteRepository
{
    public function add(RankedTitleList $rankedTitleList): void;
}
