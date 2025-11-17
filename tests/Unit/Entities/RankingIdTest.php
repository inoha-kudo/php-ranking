<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Entities;

use Miraiportal\Ranking\Entities\RankingId;
use PHPUnit\Framework\TestCase;

final class RankingIdTest extends TestCase
{
    public function test_of_with_value_at_min(): void
    {
        $this->expectNotToPerformAssertions();

        RankingId::of(RankingId::MIN);
    }

    public function test_of_with_value_at_max(): void
    {
        $this->expectNotToPerformAssertions();

        RankingId::of(RankingId::MAX);
    }

    public function test_of_with_value_less_than_min(): void
    {
        $value = RankingId::MIN - 1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            RankingId::EXCEPTION_MESSAGE_VALUE_LESS_THAN_MIN,
            $value,
            RankingId::MIN,
        ));

        RankingId::of($value);
    }

    public function test_of_with_value_greater_than_max(): void
    {
        $value = RankingId::MAX + 1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            RankingId::EXCEPTION_MESSAGE_VALUE_GREATER_THAN_MAX,
            $value,
            RankingId::MAX,
        ));

        RankingId::of($value);
    }

    public function test_value(): void
    {
        $value = RankingId::MIN;

        $this->assertSame(
            $value,
            RankingId::of($value)->value,
        );
    }
}
