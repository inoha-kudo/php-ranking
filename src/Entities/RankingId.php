<?php

declare(strict_types=1);

namespace Miraiportal\Ranking\Entities;

final readonly class RankingId
{
    private const int UINT8_MAX = 255;

    public const int MIN = 1;

    public const int MAX = self::UINT8_MAX;

    public const string EXCEPTION_MESSAGE_VALUE_LESS_THAN_MIN = 'The provided value (%d) must be greater than or equal to %d.';

    public const string EXCEPTION_MESSAGE_VALUE_GREATER_THAN_MAX = 'The provided value (%d) must be less than or equal to %d.';

    private function __construct(
        public int $value,
    ) {
        /** @phpstan-ignore-next-line */
        assert(self::MIN <= self::MAX);

        if ($value < self::MIN) {
            throw new \InvalidArgumentException(sprintf(
                self::EXCEPTION_MESSAGE_VALUE_LESS_THAN_MIN,
                $value,
                self::MIN,
            ));
        }
        if ($value > self::MAX) {
            throw new \InvalidArgumentException(sprintf(
                self::EXCEPTION_MESSAGE_VALUE_GREATER_THAN_MAX,
                $value,
                self::MAX,
            ));
        }
    }

    public static function of(int $value): self
    {
        return new self($value);
    }
}
