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
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Switzerland implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->getFederalDayofThanksgivingRepentanceAndPrayer($year, HolidayType::OTHER, $timezone));

        if ($year >= 1994) {
            $holidays->add($this->getSwissNationalDay($year, HolidayType::DAY_OFF, $timezone));
        } else {
            $holidays->add($this->getSwissNationalDay($year, HolidayType::OTHER, $timezone));
        }

        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));

        return $holidays;
    }

    protected function getBerchtoldstag(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::BERCHTOLDSTAG, new \DateTime(sprintf('%s-01-02', $year), $timezone), HolidayType::TRADITIONAL | $additionalType);
    }

    private function getSwissNationalDay(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::SWISS_NATIONAL_DAY, new \DateTime(sprintf('%s-08-01', $year), $timezone), HolidayType::OFFICIAL | $additionalType);
    }

    protected function getDateForFederalDayofThanksgivingRepentanceAndPrayer(int $year, \DateTimeZone $timezone = null): \DateTime
    {
        return new \DateTime(sprintf('First Sunday of %s-09', $year), $timezone);
    }

    private function getFederalDayofThanksgivingRepentanceAndPrayer(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        return new Holiday(HolidayName::SWISS_NATIONAL_DAY, $this->getDateForFederalDayofThanksgivingRepentanceAndPrayer($year, $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    protected function getBettagsmontag(int $year, int $additionalType = HolidayType::OTHER, \DateTimeZone $timezone = null): Holiday
    {
        $date = $this->getDateForFederalDayofThanksgivingRepentanceAndPrayer($year, $timezone);
        $date->add(new \DateInterval('P1D'));

        return new Holiday(HolidayName::BETTAGSMONTAG, $date, HolidayType::RELIGIOUS | $additionalType);
    }
}
