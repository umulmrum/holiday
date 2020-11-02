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

class Geneva extends Switzerland
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = parent::calculateHolidaysForYear($year);

        $holidays->add($this->getBerchtoldstag($year, HolidayType::DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getGenferBettag($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1814) {
            $holidays->add($this->getRestorationOfTheRepublic($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        }

        return $holidays;
    }

    private function getGenferBettag(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = $this->getDateForFederalDayofThanksgivingRepentanceAndPrayer($year);
        $date->add(new \DateInterval('P4D'));

        return Holiday::createFromDateTime(HolidayName::GENFER_BETTAG, $date, HolidayType::OFFICIAL | $additionalType);
    }

    private function getRestorationOfTheRepublic(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::GENEVA_RESTORATION_OF_THE_REPUBLIC, "{$year}-12-31", HolidayType::OFFICIAL | $additionalType);
    }
}
