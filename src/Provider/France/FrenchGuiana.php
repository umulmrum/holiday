<?php

namespace umulmrum\Holiday\Provider\France;

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class FrenchGuiana extends France
{
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);
        $holidays->add($this->getAbolitionOfSlavery($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getAbolitionOfSlavery(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ABOLITION_OF_SLAVERY, "{$year}-06-10", HolidayType::OTHER | $additionalType);
    }
}
