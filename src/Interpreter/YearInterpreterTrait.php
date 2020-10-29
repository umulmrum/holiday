<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Interpreter;

/**
 * @internal
 */
trait YearInterpreterTrait
{
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
            foreach ($years as $year) {
                if (false === \is_int($year)) {
                    throw new \InvalidArgumentException('Year needs to be either int or an array of int');
                }
            }

            return $years;
        }

        throw new \InvalidArgumentException('Year needs to be either int or an array of int');
    }
}
