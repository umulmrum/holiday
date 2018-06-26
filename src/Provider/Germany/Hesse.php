<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Germany;

use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Constant\Weekday;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;
use umulmrum\Holiday\Provider\Weekday\WeekdayTrait;

class Hesse extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;
    use WeekdayTrait;

    const ID = 'DE-HE';

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return self::ID;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null)
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);
        $sundays = $this->getWeekdays($year, Weekday::SUNDAY, HolidayType::DAY_OFF, $timezone);
        foreach ($sundays as $sunday) {
            $holidays->add($sunday);
        }
        $holidays->add($this->getCorpusChristi($year, HolidayType::OTHER, $timezone));

        return $holidays;
    }
}
