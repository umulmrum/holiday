<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Provider\Belgium;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Belgium implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEpiphany($year, HolidayType::OTHER));
        $holidays->add($this->getValentinesDay($year, HolidayType::OTHER));
        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAscension($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getWhitSunday($year, HolidayType::OTHER));
        $holidays->add($this->getWhitMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1973) {
            $holidays->add($this->getDayOfTheFlemishCommunity($year));
        }
        if ($year >= 1890) {
            $holidays->add($this->getBelgianNationalHoliday($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1975) {
            $holidays->add($this->getFrenchCommunityHoliday($year));
        }
        if ($year >= 1998) {
            $holidays->add($this->getDayOfTheWalloonRegion($year));
        }
        $holidays->add($this->getHalloween($year));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAllSoulsDay($year));
        $holidays->add($this->getArmisticeDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1990) {
            $holidays->add($this->getDayofTheGermanSpeakingCommunity($year, HolidayType::OTHER));
        }
        if ($year >= 1866) {
            $holidays->add($this->getKingsFeast($year));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getBelgianNationalHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::BELGIAN_NATIONAL_HOLIDAY, "{$year}-07-21", $additionalType | HolidayType::OFFICIAL);
    }

    private function getDayOfTheFlemishCommunity(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_FLEMISH_COMMUNITY, "{$year}-07-11", $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getFrenchCommunityHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::FRENCH_COMMUNITY_HOLIDAY, "{$year}-09-27", $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getDayOfTheWalloonRegion(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::createFromDateTime(
            HolidayName::DAY_OF_THE_WALLOON_REGION,
            new \DateTime("Third Sunday of {$year}-09"),
            $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY
        );
    }

    private function getArmisticeDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ARMISTICE_DAY, "{$year}-11-11", $additionalType | HolidayType::OFFICIAL);
    }

    private function getDayofTheGermanSpeakingCommunity(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_GERMAN_SPEAKING_COMMUNITY, "{$year}-11-15", $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getKingsFeast(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::BELGIAN_KINGS_FEAST, "{$year}-11-15", $additionalType | HolidayType::TRADITIONAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED);
    }
}
