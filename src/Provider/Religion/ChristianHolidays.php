<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Religion;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

final class ChristianHolidays implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidayList = new HolidayList();
        $holidayList->add($this->getEpiphany($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getCandlemas($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getValentinesDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSaintJosephsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAshWednesday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getMaundyThursday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getGoodFriday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getEasterSunday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getEasterMonday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAscension($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getWhitSunday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getWhitMonday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getCorpusChristi($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSaintFloriansDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getFeastofSaintsPeterAndPaul($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAssumptionDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getNativityOfMary($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSaintMauriceDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getReformationDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getHalloween($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAllSaintsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAllSoulsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSaintMartinsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getLeopoldsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getRepentanceAndPrayerDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getImmaculateConception($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getChristmasEve($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getChristmasDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSecondChristmasDay($year, HolidayType::OTHER, $timezone));

        return $holidayList;
    }
}
