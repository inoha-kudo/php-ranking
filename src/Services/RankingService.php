<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Services;

use Miraiportal\Ranking\Contracts\RankingReadRepository;
use Miraiportal\Ranking\Contracts\RankingWriteRepository;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Repositories\RankingNullReadRepository;
use Miraiportal\Ranking\Repositories\RankingNullWriteRepository;

final readonly class RankingService
{
    public function __construct(
        private RankingReadRepository $readRepository = new RankingNullReadRepository,
        private RankingWriteRepository $writeRepository = new RankingNullWriteRepository,
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
