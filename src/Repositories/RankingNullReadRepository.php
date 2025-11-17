<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Repositories;

use Miraiportal\Ranking\Contracts\RankingReadRepository;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;

final readonly class RankingNullReadRepository implements RankingReadRepository
{
    /** @param array<string, mixed> $params */
    #[\Override]
    public function getAll(RankingId $rankingId, array $params = []): RankedTitleList
    {
        return RankedTitleList::from();
    }
}
