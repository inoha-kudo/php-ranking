<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Contracts;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;

interface RankingReadRepository
{
    /** @param array<string, mixed> $params */
    public function getAll(RankingId $rankingId, array $params = []): RankedTitleList;
}
