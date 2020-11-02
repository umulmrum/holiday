<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Interpreter;

use Umulmrum\Holiday\Assert\Assert;

/**
 * @internal
 */
trait YearInterpreterTrait
{
    use Assert;

    /**
     * @param int|int[] $years
     *
     * @return int[]
     */
    private function interpretYears($years): array
    {
        if (\is_int($years)) {
            return [$years];
        }

        if (\is_array($years)) {
            $this->assertIntArray($years);

            return $years;
        }

        throw new \InvalidArgumentException('Year needs to be either int or an array of int');
    }
}
