<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Austria;

use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Geneva extends Switzerland
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);

        $holidays->add($this->getBerchtoldstag($year, HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getGenferBettag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        if ($year >= 1814) {
            $holidays->add($this->getRestorationOfTheRepublic($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        }

        return $holidays;
    }

    private function getGenferBettag(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        $date = $this->getDateForFederalDayofThanksgivingRepentanceAndPrayer($year, $timezone);
        $date->add(new \DateInterval('P4D'));

        return new Holiday(HolidayName::GENFER_BETTAG, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getRestorationOfTheRepublic(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::GENEVA_RESTORATION_OF_THE_REPUBLIC, new \DateTime(sprintf('%s-12-31', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}
