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

class Neuchatel extends Switzerland
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year, $timezone);

        $berchtoldstag = $this->getBerchtoldstag($year, HolidayType::OTHER, $timezone);
        if ('1' === $berchtoldstag->getDate()->format('w')) { // if Monday
            $holidays->add($this->getBerchtoldstag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        } else {
            $holidays->add($this->getBerchtoldstag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        }

        if ($year >= 1848) {
            $holidays->add($this->getRepublicAnniversary($year, HolidayType::DAY_OFF, $timezone));
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getWhitMonday($year, HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getCorpusChristi($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY, $timezone));
        $holidays->add($this->getBettagsmontag($year, HolidayType::DAY_OFF, $timezone));

        $secondChristmasDay = $this->getSecondChristmasDay($year, HolidayType::OTHER, $timezone);
        if ('1' === $secondChristmasDay->getDate()->format('w')) { // if Monday
            $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        }

        return $holidays;
    }

    private function getRepublicAnniversary(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::JAHRESTAG_AUSRUFUNG_REPUBLIK_NEUENBURG, new \DateTime(sprintf('%s-03-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }
}
