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

class ChristianHolidays implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidayList = new HolidayList();
        $holidayList->add($this->getEpiphany($year));
        $holidayList->add($this->getCandlemas($year));
        $holidayList->add($this->getValentinesDay($year));
        $holidayList->add($this->getSaintJosephsDay($year));
        $holidayList->add($this->getFatTuesday($year));
        $holidayList->add($this->getAshWednesday($year));
        $holidayList->add($this->getMaundyThursday($year));
        $holidayList->add($this->getGoodFriday($year));
        $holidayList->add($this->getEasterSunday($year));
        $holidayList->add($this->getEasterMonday($year));
        $holidayList->add($this->getAscension($year));
        $holidayList->add($this->getWhitSunday($year));
        $holidayList->add($this->getWhitMonday($year));
        $holidayList->add($this->getCorpusChristi($year));
        $holidayList->add($this->getSaintFloriansDay($year));
        $holidayList->add($this->getFeastofSaintsPeterAndPaul($year));
        $holidayList->add($this->getAssumptionDay($year));
        $holidayList->add($this->getNativityOfMary($year));
        $holidayList->add($this->getSaintMauriceDay($year));
        $holidayList->add($this->getReformationDay($year));
        $holidayList->add($this->getHalloween($year));
        $holidayList->add($this->getAllSaintsDay($year));
        $holidayList->add($this->getAllSoulsDay($year));
        $holidayList->add($this->getSaintMartinsDay($year));
        $holidayList->add($this->getLeopoldsDay($year));
        $holidayList->add($this->getRepentanceAndPrayerDay($year));
        $holidayList->add($this->getImmaculateConception($year));
        $holidayList->add($this->getChristmasEve($year));
        $holidayList->add($this->getChristmasDay($year));
        $holidayList->add($this->getSecondChristmasDay($year));

        return $holidayList;
    }
}
