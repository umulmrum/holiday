<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Germany;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Constant\Weekday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use Umulmrum\Holiday\Provider\Weekday\WeekdayTrait;

class Hesse extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use WeekdayTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $sundays = $this->getWeekdays($year, Weekday::SUNDAY, HolidayType::DAY_OFF);
        foreach ($sundays as $sunday) {
            $holidays->add($sunday);
        }
        $holidays->add($this->getCorpusChristi($year, HolidayType::OTHER));

        return $holidays;
    }
}
