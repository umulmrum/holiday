<?php

namespace Umulmrum\Holiday\Provider\Brazil;

use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\CommonHolidaysTrait;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;
use Umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;

class Brazil implements HolidayProviderInterface
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
        $holidays->add($this->getFatTuesday($year, HolidayType::PARTIAL_ONLY | HolidayType::DAY_OFF));
        $holidays->add($this->getAshWednesday($year, HolidayType::PARTIAL_ONLY | HolidayType::HALF_DAY_OFF));
        $holidays->add($this->getGoodFriday($year, HolidayType::PARTIAL_ONLY | HolidayType::DAY_OFF));
        if ($year >= 1889) {
            $holidays->add($this->getTiradentes($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF));
        if ($year >= 1949) {
            $holidays->add($this->getIndependenceDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getOurLadyOfAparecida($year));
        if (0 === $year % 2) {
            $holidays->add($this->getElectoralDayRoundOne($year));
            $holidays->add($this->getElectoralDayRoundTwo($year));
        }
        $holidays->add($this->getDayOfTheDead($year, HolidayType::DAY_OFF));
        if ($year >= 1890) {
            $holidays->add($this->getRepublicProclamationDay($year, HolidayType::DAY_OFF));
        }
        $holidays->add($this->getChristmasDay($year, HolidayType::DAY_OFF));

        return $holidays;
    }

    private function getTiradentes(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::TIRADENTES, "{$year}-04-21", HolidayType::OFFICIAL | $additionalType);
    }

    private function getIndependenceDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::INDEPENDENCE_DAY, "{$year}-09-07", HolidayType::OFFICIAL | $additionalType);
    }

    private function getOurLadyOfAparecida(int $year): Holiday
    {
        if ($year >= 1980) {
            $type = HolidayType::OFFICIAL | HolidayType::DAY_OFF;
        } else {
            $type = HolidayType::TRADITIONAL;
        }

        return Holiday::create(HolidayName::OUR_LADY_OF_APARECIDA, "{$year}-10-12", $type);
    }

    private function getElectoralDayRoundOne(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("First Sunday of {$year}-10"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::ELECTORAL_DAY_ROUND_ONE, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF | $additionalType);
    }

    private function getElectoralDayRoundTwo(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        $date = (new \DateTime("Last Sunday of {$year}-10"))->format(Holiday::DISPLAY_DATE_FORMAT);

        return Holiday::create(HolidayName::ELECTORAL_DAY_ROUND_TWO, $date, HolidayType::OFFICIAL | HolidayType::DAY_OFF | $additionalType);
    }

    private function getDayOfTheDead(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::DAY_OF_THE_DEAD, "{$year}-11-02", HolidayType::OFFICIAL | HolidayType::RELIGIOUS | $additionalType);
    }

    private function getRepublicProclamationDay(int $year, int $additionalType = HolidayType::OTHER): Holiday
    {
        return Holiday::create(HolidayName::REPUBLIC_PROCLAMATION_DAY, "{$year}-11-15", HolidayType::OFFICIAL | HolidayType::RELIGIOUS | $additionalType);
    }
}
