<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Repositories;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;

final readonly class RankingNullRepository implements RankingReadRepository, RankingWriteRepository
{
    /** @param array<string, mixed> $params */
    public function getAll(RankingId $rankingId, array $params = []): RankedTitleList
    {
        return RankedTitleList::from();
    }

    public function add(RankedTitleList $rankedTitleList): void {}
}
