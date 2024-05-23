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
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Thuringia extends Germany
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getCorpusChristi($year, HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getReformationDay($year, HolidayType::DAY_OFF));
        $holidays->add($this->getInternationalChildrensDay($year, '09', '20', HolidayType::DAY_OFF));

        return $holidays;
    }
}
