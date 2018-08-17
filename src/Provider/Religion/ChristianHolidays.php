<?php


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
        $holidayList->add($this->getGoodFriday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getEasterSunday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getEasterMonday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAscension($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getWhitSunday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getWhitMonday($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getCorpusChristi($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAssumptionDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getReformationDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getAllSaintsDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getRepentanceAndPrayerDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getChristmasDay($year, HolidayType::OTHER, $timezone));
        $holidayList->add($this->getSecondChristmasDay($year, HolidayType::OTHER, $timezone));

        return $holidayList;
    }
}