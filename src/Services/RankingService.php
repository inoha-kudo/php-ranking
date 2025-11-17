<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Services;

use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Repositories\RankingNullRepository;
use Miraiportal\Ranking\Repositories\RankingReadRepository;
use Miraiportal\Ranking\Repositories\RankingWriteRepository;

final readonly class RankingService
{
    public function __construct(
        private RankingReadRepository $readRepository = new RankingNullRepository,
        private RankingWriteRepository $writeRepository = new RankingNullRepository,
    ) {}

    /** @param array<string, mixed> $params */
    public function getAll(RankingId $rankingId, array $params = []): RankedTitleList
    {
        return $this->readRepository->getAll($rankingId, $params);
    }

    public function add(RankedTitleList $rankedTitleList): void
    {
        $this->writeRepository->add($rankedTitleList);
    }

    /** @param array<string, mixed> $params */
    public function ingest(RankingId $rankingId, array $params = []): void
    {
        $this->getAll($rankingId, $params)
            |> $this->add(...);
    }
}
