<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Tests\Unit\Entities;

use Miraiportal\Ranking\Entities\Rank;
use PHPUnit\Framework\TestCase;

final class RankTest extends TestCase
{
    public function test_of_with_value_at_min(): void
    {
        $this->expectNotToPerformAssertions();

        Rank::of(Rank::MIN);
    }

    public function test_of_with_value_at_max(): void
    {
        $this->expectNotToPerformAssertions();

        Rank::of(Rank::MAX);
    }

    public function test_of_with_value_less_than_min(): void
    {
        $value = Rank::MIN - 1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            Rank::EXCEPTION_MESSAGE_VALUE_LESS_THAN_MIN,
            $value,
            Rank::MIN,
        ));

        Rank::of($value);
    }

    public function test_of_with_value_greater_than_max(): void
    {
        $value = Rank::MAX + 1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            Rank::EXCEPTION_MESSAGE_VALUE_GREATER_THAN_MAX,
            $value,
            Rank::MAX,
        ));

        Rank::of($value);
    }

    public function test_value(): void
    {
        $value = Rank::MIN;

        $this->assertSame(
            $value,
            Rank::of($value)->value,
        );
    }
}
