<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use Umulmrum\Holiday\Assert\Assert;
use Umulmrum\Holiday\Model\Holiday;

/**
 * IncludeWeekdayFilter retains all holidays that are on a weekday passed as constructor argument.
 * Either a single weekday may be passed as an integer (use constants in the Weekday class), or an array of integers to
 * retain more than one weekday.
 */
final class IncludeWeekdayFilter extends AbstractFilter
{
    use Assert;

    /**
     * @var int[]
     */
    private $weekdays = [];

    /**
     * @param int|int[] $weekdays
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($weekdays)
    {
        if (\is_int($weekdays)) {
            $this->assertWeekday($weekdays);
            $this->weekdays = [
                $weekdays,
            ];
        } elseif (\is_array($weekdays)) {
            $this->assertArrayNotEmpty($weekdays);
            foreach ($weekdays as $weekday) {
                $this->assertWeekday($weekday);
                $this->weekdays = $weekdays;
            }
        } else {
            throw new \InvalidArgumentException('Argument must be either an integer or an array of integers.');
        }
        $this->weekdays = \array_flip($this->weekdays);
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        return true === isset($this->weekdays[(int) $holiday->getDate()->format('w')]);
    }
}
