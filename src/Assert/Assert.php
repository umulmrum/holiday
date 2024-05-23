<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Assert;

use InvalidArgumentException;
use Umulmrum\Holiday\Constant\Weekday;

use function count;
use function is_int;
use function print_r;
use function sprintf;

trait Assert
{
    /**
     * @throws InvalidArgumentException
     */
    private function assertInt(mixed $value): void
    {
        if (false === is_int($value)) {
            throw new InvalidArgumentException('int expected, got: ' . (string) $value);
        }
    }

    /**
     * @param mixed[] $value
     *
     * @throws InvalidArgumentException
     */
    private function assertIntArray(array $value): void
    {
        foreach ($value as $item) {
            if (false === is_int($item)) {
                throw new InvalidArgumentException('array of int expected, got: ' . print_r($value, true));
            }
        }
    }

    /**
     * @param mixed[] $value
     */
    private function assertArrayNotEmpty(array $value): void
    {
        if (0 === count($value)) {
            throw new InvalidArgumentException('array must not be empty');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertWeekday(mixed $value): void
    {
        $this->assertInt($value);
        if ($value < Weekday::SUNDAY || $value > Weekday::SATURDAY) {
            throw new InvalidArgumentException(sprintf(
                'Invalid weekday "%s". Expected value between %s and %s.',
                $value,
                Weekday::SUNDAY,
                Weekday::SATURDAY
            ));
        }
    }
}
