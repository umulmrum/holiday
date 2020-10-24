<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Weekday;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Model\Holiday;

trait WeekdayTrait
{
    /**
     * @return Holiday[]
     */
    private function getWeekdays(int $year, int $weekday, int $additionalType = HolidayType::OTHER): array
    {
        $start = \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-01-01', $year));
        $end = \DateTime::createFromFormat(Holiday::DATE_FORMAT, \sprintf('%s-01-01', $year + 1));
        $day = new \DateTime();
        $weekdayName = Weekday::$NAME[$weekday];
        $day->setTimestamp(strtotime($weekdayName, $start->getTimestamp()));
        $holidays = [];

        while ($day->getTimestamp() < $endDate = $end->getTimestamp()) {
            $holidays[] = new Holiday($weekdayName, clone $day, HolidayType::DAY_OFF | $additionalType);
            $day->add(new \DateInterval('P7D'));
        }

        return $holidays;
    }
}
