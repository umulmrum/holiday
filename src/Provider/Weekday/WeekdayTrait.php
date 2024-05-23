<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Weekday;

use DateInterval;
use DateTime;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Provider\DateCreatorTrait;

use function sprintf;
use function strtotime;

trait WeekdayTrait
{
    use DateCreatorTrait;

    /**
     * @return Holiday[]
     */
    private function getWeekdays(int $year, int $weekday, int $additionalType = HolidayType::OTHER): array
    {
        $start = $this->createDateFromString(sprintf('%s-01-01', $year));
        $end = $this->createDateFromString(sprintf('%s-01-01', $year + 1));
        $day = new DateTime();
        $weekdayName = Weekday::$NAME[$weekday];
        // @phpstan-ignore-next-line
        $day->setTimestamp(strtotime($weekdayName, $start->getTimestamp()));

        $holidays = [];
        while ($day->getTimestamp() < $endDate = $end->getTimestamp()) {
            $holidays[] = Holiday::createFromDateTime($weekdayName, $day, HolidayType::OTHER | $additionalType);
            $day->add(new DateInterval('P7D'));
        }

        return $holidays;
    }
}
