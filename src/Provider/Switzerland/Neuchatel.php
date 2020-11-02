<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Switzerland;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Neuchatel extends Switzerland
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);

        $berchtoldstag = $this->getBerchtoldstag($year, HolidayType::OTHER);
        if ('1' === $berchtoldstag->getDate()->format('w')) { // if Monday
            $holidays->add($this->getBerchtoldstag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        } else {
            $holidays->add($this->getBerchtoldstag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        }

        if ($year >= 1848) {
            $holidays->add($this->getRepublicAnniversary($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::DAY_OFF));
        $holidays->add($this->getCorpusChristi($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::PARTIAL_ONLY));
        $holidays->add($this->getBettagsmontag($year, HolidayType::DAY_OFF));

        $secondChristmasDay = $this->getSecondChristmasDay($year, HolidayType::OTHER);
        if ('1' === $secondChristmasDay->getDate()->format('w')) { // if Monday
            $holidays->add($this->getSecondChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }

        return $holidays;
    }

    private function getRepublicAnniversary(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::JAHRESTAG_AUSRUFUNG_REPUBLIK_NEUENBURG, "{$year}-03-01", HolidayType::OFFICIAL | $additionalType);
    }
}
