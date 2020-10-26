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

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

final class ApplyTimezoneFilter implements HolidayFilterInterface
{
    /**
     * @var \DateTimeZone
     */
    private $dateTimeZone;

    public function __construct(\DateTimeZone $dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    public function filter(HolidayList $holidayList): void
    {
        foreach ($holidayList->getList() as $index => $holiday) {
            $holidayList->replaceByIndex($index, new Holiday(
                $holiday->getName(),
                \DateTimeImmutable::createFromFormat(Holiday::DATE_FORMAT, $holiday->getFormattedDate('Y-m-d'), $this->dateTimeZone),
                $holiday->getType()
            ));
        }
    }
}
