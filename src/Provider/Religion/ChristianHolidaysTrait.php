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

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;

trait ChristianHolidaysTrait
{
    /** @var \DateTimeImmutable[] */
    private $easterCache = [];

    private function getEasterSundayDate(int $year): \DateTimeImmutable
    {
        if (false === isset($this->easterCache[$year])) {
            $this->easterCache[$year] = \DateTimeImmutable::createFromFormat(Holiday::DISPLAY_DATE_FORMAT, $this->calculateEasterSunday($year));
        }

        return $this->easterCache[$year];
    }

    /**
     * Taken from http://www.whydomath.org/Reading_Room_Material/ian_stewart/2000_03.html.
     *
     * Choose any year of the Gregorian calendar and call it x. To determine the date of Eas-ter, carry out the following 10 calculations (it’s easy to program them on a computer):
     *
     * 1. Divide x by 19 to get a quotient (which we ignore) and a remainder A. This is the year’s position in the 19-year lunar cycle. (A + 1 is the year’s Golden Number.)
     *
     * 2. Divide x by 100 to get a quotient B and a remainder C.
     *
     * 3. Divide B by 4 to get a quotient D and a remainder E.
     *
     * 4. Divide 8B + 13 by 25 to get a quotient G and a remainder (which we ignore).
     *
     * 5. Divide 19A + B – D – G + 15 by 30 to get a quotient (which we ignore) and a remainder H.
     * (The year’s Epact is 23 – H when H is less than 24 and 53 – H otherwise.)
     *
     * 6. Divide A + 11H by 319 to get a quotient M and a remainder (which we ignore).
     *
     * 7. Divide C by 4 to get a quotient J and a remainder K.
     *
     * 8. Divide 2E + 2J – K – H + M + 32 by 7 to get a quotient (which we ignore) and a remainder L.
     *
     * 9. Divide H – M + L + 90 by 25 to get a quotient N and a remainder (which we ignore).
     *
     * 10. Divide H – M + L + N + 19 by 32 to get a quotient (which we ignore) and a remainder P.Easter Sunday is the Pth day of the Nth month (N can be either 3 for March or 4 for April). The year’s dominical letter can be found by dividing 2E + 2J – K by 7 and taking the remainder (a remainder of 0 is equivalent to the letter A, 1 is equivalent to B, and so on).
     *
     * Let’s try this method for x = 2001: (1) A = 6; (2) B = 20, C = 1; (3) D = 5, E = 0; (4) G = 6; (5) H = 18; (6) M = 0; (7) J = 0, K = 1; (8) L = 6; (9) N = 4; (10) P = 15. So Easter 2001 is April 15.
     */
    private function calculateEasterSunday(int $year): string
    {
        $a = $year % 19;
        $b = \intdiv($year, 100);
        $c = $year % 100;
        $d = \intdiv($b, 4);
        $e = $b % 4;
        $g = \intdiv(8 * $b + 13, 25);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $j = \intdiv($c, 4);
        $k = $c % 4;
        $m = \intdiv($a + 11 * $h, 319);
        $l = (2 * $e + 2 * $j - $h - $k + $m + 32) % 7;
        $n = \intdiv($h - $m + $l + 90, 25);
        $p = ($h - $m + $l + $n + 19) % 32;

        return "$year-$n-$p";
    }

    private function getEpiphany(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::EPIPHANY, "{$year}-01-06", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getCandlemas(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::CANDLEMAS, "{$year}-02-02", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getValentinesDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::VALENTINES_DAY, "{$year}-02-14", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getSaintJosephsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINT_JOSEPHS_DAY, "{$year}-03-19", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getFatTuesday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::FAT_TUESDAY, $easterSunday->sub(new \DateInterval('P47D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getAshWednesday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::ASH_WEDNESDAY, $easterSunday->sub(new \DateInterval('P46D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getMaundyThursday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::MAUNDY_THURSDAY, $easterSunday->sub(new \DateInterval('P3D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getGoodFriday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::GOOD_FRIDAY, $easterSunday->sub(new \DateInterval('P2D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getEasterSunday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::EASTER_SUNDAY, $easterSunday, HolidayType::RELIGIOUS | $additionalType);
    }

    private function getEasterMonday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::EASTER_MONDAY, $easterSunday->add(new \DateInterval('P1D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getAscension(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::ASCENSION, $easterSunday->add(new \DateInterval('P39D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getWhitSunday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::WHIT_SUNDAY, $easterSunday->add(new \DateInterval('P49D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getWhitMonday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::WHIT_MONDAY, $easterSunday->add(new \DateInterval('P50D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getCorpusChristi(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $easterSunday = $this->getEasterSundayDate($year);

        return Holiday::createFromDateTime(HolidayName::CORPUS_CHRISTI, $easterSunday->add(new \DateInterval('P60D')), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getSaintFloriansDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINT_FLORIANS_DAY, "{$year}-05-04", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getFeastofSaintsPeterAndPaul(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::FEAST_OF_SAINTS_PETER_AND_PAUL, "{$year}-06-29", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getAssumptionDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ASSUMPTION_DAY, "{$year}-08-15", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getNativityOfMary(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::NATIVITY_OF_MARY, "{$year}-09-08", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getSaintMauriceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINT_MAURICE_DAY, "{$year}-09-22", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getReformationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::REFORMATION_DAY, "{$year}-10-31", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getHalloween(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::HALLOWEEN, "{$year}-10-31", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getAllSaintsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ALL_SAINTS_DAY, "{$year}-11-01", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getAllSoulsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ALL_SOULS_DAY, "{$year}-11-02", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getSaintMartinsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SAINT_MARTINS_DAY, "{$year}-11-11", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getLeopoldsDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::LEOPOLDS_DAY, "{$year}-11-15", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getRepentanceAndPrayerDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $christmasEve = \DateTimeImmutable::createFromFormat(Holiday::DISPLAY_DATE_FORMAT, "{$year}-12-24");
        $changeBy = 32 + ((int) date('w', $christmasEve->getTimestamp()));

        return Holiday::createFromDateTime(HolidayName::REPENTANCE_AND_PRAYER_DAY, $christmasEve->sub(new \DateInterval("P{$changeBy}D")), HolidayType::RELIGIOUS | $additionalType);
    }

    private function getImmaculateConception(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::IMMACULATE_CONCEPTION, "{$year}-12-08", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getChristmasEve(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::CHRISTMAS_EVE, "{$year}-12-24", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getChristmasDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::CHRISTMAS_DAY, "{$year}-12-25", HolidayType::RELIGIOUS | $additionalType);
    }

    private function getSecondChristmasDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::SECOND_CHRISTMAS_DAY, "{$year}-12-26", HolidayType::RELIGIOUS | $additionalType);
    }
}
