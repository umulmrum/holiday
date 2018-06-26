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

use DateInterval;
use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;

trait ChristianHolidaysTrait
{
    private $easterCache = [];

    /**
     * @param int          $year
     * @param DateTimeZone $timezone
     *
     * @return DateTime
     */
    private function getEasterSundayDate($year, DateTimeZone $timezone = null)
    {
        if (isset($this->easterCache[$year])) {
            return clone $this->easterCache[$year];
        }
        /*
         * We do not use easter_days in orderto avoid timezone surprises, see https://secure.php.net/manual/en/function.easter-date.php
         */
        $base = new DateTime(sprintf('%s-03-21', $year), $timezone);
        $days = \easter_days($year);

        $easterDate = $base->add(new DateInterval("P{$days}D"));
        $this->easterCache[$year] = clone $easterDate;

        return $easterDate;
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getEpiphany($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::EPIPHANY, new DateTime(sprintf('%s-01-06', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getGoodFriday($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::GOOD_FRIDAY, $easterSunday->sub(new DateInterval('P2D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getEasterSunday($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::EASTER_SUNDAY, $easterSunday, HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getEasterMonday($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::EASTER_MONDAY, $easterSunday->add(new DateInterval('P1D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getAscension($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::ASCENCION, $easterSunday->add(new DateInterval('P39D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int $year
     * @param int $additionalType
     *
     * @return Holiday
     */
    private function getWhitSunday($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::WHIT_SUNDAY, $easterSunday->add(new DateInterval('P49D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getWhitMonday($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::WHIT_MONDAY, $easterSunday->add(new DateInterval('P50D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getCorpusChristi($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $easterSunday = $this->getEasterSundayDate($year, $timezone);

        return new Holiday(HolidayName::CORPUS_CHRISTI, $easterSunday->add(new DateInterval('P60D')), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getAssumptionDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::ASSUMPTION_DAY, new DateTime(sprintf('%s-08-15', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getReformationDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::REFORMATION_DAY, new DateTime(sprintf('%s-10-31', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getAllSaintsDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::ALL_SAINTS_DAY, new DateTime(sprintf('%s-11-01', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getRepentanceAndPrayerDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        $christmasEve = new DateTime(sprintf('%s-12-24', $year), $timezone);
        $changeBy = 32 + ((int) date('w', $christmasEve->getTimestamp()));

        return new Holiday(HolidayName::REPENTANCE_AND_PRAYER_DAY, $christmasEve->sub(new DateInterval("P{$changeBy}D")), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getChristmasDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::CHRISTMAS_DAY, new DateTime(sprintf('%s-12-25', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }

    /**
     * @param int          $year
     * @param int          $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getSecondChristmasDay($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::SECOND_CHRISTMAS_DAY, new DateTime(sprintf('%s-12-26', $year), $timezone), HolidayType::RELIGIOUS | $additionalType);
    }
}
