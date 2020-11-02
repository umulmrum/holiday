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
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;

/**
 * IncludeTypeFilter retains all holidays with one or more types passed as constructor argument.
 * Multiple types can be given either as a bitmask in a single integer, or as separate types in an integer array.
 */
final class IncludeTypeFilter extends AbstractFilter
{
    use Assert;

    /**
     * @var int
     */
    private $holidayTypes = HolidayType::OTHER;

    /**
     * @param int|int[] $holidayTypes
     */
    public function __construct($holidayTypes)
    {
        if (\is_int($holidayTypes)) {
            $this->holidayTypes = $holidayTypes;
        } elseif (\is_array($holidayTypes)) {
            foreach ($holidayTypes as $holidayType) {
                $this->assertInt($holidayType);
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
