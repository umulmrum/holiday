<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Religion;

use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

class ChristianOrthodoxHolidays implements HolidayProviderInterface
{
    use ChristianOrthodoxHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidayList = new HolidayList();
        $holidayList->add($this->getGoodFriday($year));
        $holidayList->add($this->getEasterSunday($year));
        $holidayList->add($this->getEasterMonday($year));
        $holidayList->add($this->getChristmasDay($year));

        return $holidayList;
    }
}
