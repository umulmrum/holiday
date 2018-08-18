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

use umulmrum\Holiday\Model\HolidayList;

class IncludeTypeFilter implements HolidayFilterInterface
{
    /**
     * @var int
     */
    private $holidayTypes = 0;

    /**
     * @param int|int[] $holidayTypes
     */
    public function __construct($holidayTypes)
    {
        if (true === \is_int($holidayTypes)) {
            $this->holidayTypes = $holidayTypes;
        } elseif (true === \is_array($holidayTypes)) {
            foreach ($holidayTypes as $holidayType) {
                $this->holidayTypes |= $holidayType;
            }
        } else {
            throw new \InvalidArgumentException('First argument must be either an integer or an array of integers.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList): HolidayList
    {
        $tempList = $holidayList->getList();
        $newList = new HolidayList();

        foreach ($tempList as $holiday) {
            if (0 !== ($holiday->getType() & $this->holidayTypes)) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
