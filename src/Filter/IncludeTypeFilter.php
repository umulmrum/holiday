<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;

/**
 * IncludeTypeFilter retains all holidays with one or more types passed as constructor argument.
 * Multiple types can be given either as a bitmask in a single integer, or as separate types in an integer array.
 */
final class IncludeTypeFilter extends AbstractFilter
{
    /**
     * @var int
     */
    private $holidayTypes = HolidayType::OTHER;

    /**
     * @param int|int[] $holidayTypes
     */
    public function __construct($holidayTypes)
    {
        if (true === \is_int($holidayTypes)) {
            $this->holidayTypes = $holidayTypes;
        } elseif (true === \is_array($holidayTypes)) {
            foreach ($holidayTypes as $holidayType) {
                if (false === \is_int($holidayType)) {
                    throw new \InvalidArgumentException('Argument must be either an integer or an array of integers.');
                }
                $this->holidayTypes |= $holidayType;
            }
        } else {
            throw new \InvalidArgumentException('Argument must be either an integer or an array of integers.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        return $holiday->hasType($this->holidayTypes);
    }
}
