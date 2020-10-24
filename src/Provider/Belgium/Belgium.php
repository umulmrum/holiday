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
            $holidays->add($this->getDayOfTheFlemishCommunity($year, HolidayType::OTHER));
        }
        if ($year >= 1890) {
            $holidays->add($this->getBelgianNationalHoliday($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getAssumptionDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1975) {
            $holidays->add($this->getFrenchCommunityHoliday($year, HolidayType::OTHER));
        }
        if ($year >= 1998) {
            $holidays->add($this->getDayOfTheWalloonRegion($year, HolidayType::OTHER));
        }
        $holidays->add($this->getHalloween($year, HolidayType::OTHER));
        $holidays->add($this->getAllSaintsDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        $holidays->add($this->getAllSoulsDay($year, HolidayType::OTHER));
        $holidays->add($this->getArmisticeDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1990) {
            $holidays->add($this->getDayofTheGermanSpeakingCommunity($year, HolidayType::OTHER));
        }
        if ($year >= 1866) {
            $holidays->add($this->getKingsFeast($year, HolidayType::OTHER));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getBelgianNationalHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::BELGIAN_NATIONAL_HOLIDAY, sprintf('%s-07-21', $year), $additionalType | HolidayType::OFFICIAL);
    }

    private function getDayOfTheFlemishCommunity(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_FLEMISH_COMMUNITY, sprintf('%s-07-11', $year), $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getFrenchCommunityHoliday(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::FRENCH_COMMUNITY_HOLIDAY, sprintf('%s-09-27', $year), $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getDayOfTheWalloonRegion(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_WALLOON_REGION, sprintf('Third Sunday of %s-09', $year), $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getArmisticeDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::ARMISTICE_DAY, sprintf('%s-11-11', $year), $additionalType | HolidayType::OFFICIAL);
    }

    private function getDayofTheGermanSpeakingCommunity(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_GERMAN_SPEAKING_COMMUNITY, sprintf('%s-11-15', $year), $additionalType | HolidayType::TRADITIONAL | HolidayType::PARTIAL_ONLY);
    }

    private function getKingsFeast(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::BELGIAN_KINGS_FEAST, sprintf('%s-11-15', $year), $additionalType | HolidayType::TRADITIONAL | HolidayType::GOVERNMENT_AGENCIES_CLOSED);
    }
}
