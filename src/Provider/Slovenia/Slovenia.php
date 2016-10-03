<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider\Slovenia;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Constant\HolidayName;
use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\Religion\ChristianHolidaysTrait;
use umulmrum\Holiday\Provider\HolidayProviderInterface;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Provider\CommonHolidaysTrait;

class Slovenia implements HolidayProviderInterface
{
    use ChristianHolidaysTrait;
    use CommonHolidaysTrait;

    const ID = 'SL';

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return self::ID;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($year, DateTimeZone $timezone = null)
    {
        $holidays = new HolidayList();
        $holidays->add($this->getNewYear($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));

        if ($year < 2012) {
            $holidays->add($this->get2Januar($year, $timezone));
        }


        if ($year >= 1946) {
            $holidays->add($this->getPresernovDan($year, $timezone));
        }


        $holidays->add($this->getEasterSunday($year, HolidayType::OFFICIAL, $timezone));
        $holidays->add($this->getEasterMonday($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));

        if ($year >= 1992) {
            $holidays->add($this->getDanUporaProtiOkupatorju($year, $timezone));
        }

        $holidays->add($this->getLaborDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));
        $holidays->add($this->get2Maj($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));

        if ($year >= 2010) {
            $holidays->add($this->getDanPrimozaTrubarja($year, $timezone));
        }

        $holidays->add($this->getAssumptionDay($year, HolidayType::DAY_OFF, $timezone));

        if ($year >= 2006) {
            $holidays->add($this->getZdruzitevPrimorskihSlovencevZMaticnimNarodom($year, $timezone));
        }

        if ($year >= 2005) {
            $holidays->add($this->getDanVrnitvePrimorskeKMaticniDomovini($year, $timezone));
        }

        if ($year >= 2015) {
            $holidays->add($this->getDanSuverenosti($year, $timezone));
        }

        $holidays->add($this->getDanReformacije($year, $timezone));
        $holidays->add($this->getDanSpominaNaMrtve($year, $timezone));

        if ($year >= 2005) {
            $holidays->add($this->getDanRudolfaMaistra($year, $timezone));
        }

        $holidays->add($this->getChristmasDay($year, HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone));


        if ($year > 1991 && $year < 2005) {
            $holidays->add($this->getDanSamostojnosti($year, $timezone));
        } else {
            $holidays->add($this->getDanSamostojnostiInEnotnosti($year, $timezone));
        }

        return $holidays;
    }


    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function get2Januar($year, DateTimeZone $timezone = null)
    {
        return new Holiday('new_year', new DateTime(sprintf('%s-01-02', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getPresernovDan($year, DateTimeZone $timezone = null)
    {
        return new Holiday('presernov_dan', new DateTime(sprintf('%s-02-08', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }


    /*
   * @param int $year
   * @param DateTimeZone $timezone
   *
   * @return Holiday
   */
    private function getDanUporaProtiOkupatorju($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_upora_proti_okupatorju', new DateTime(sprintf('%s-04-27', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }

    /**
     * @param int $year
     * @param int $additionalType
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function get2Maj($year, $additionalType = HolidayType::OTHER, DateTimeZone $timezone = null)
    {
        return new Holiday(HolidayName::LABOR_DAY, new DateTime(sprintf('%s-05-02', $year)), HolidayType::OFFICIAL | $additionalType, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanPrimozaTrubarja($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_primoza_trubarja', new DateTime(sprintf('%s-06-08', $year)), HolidayType::OFFICIAL, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getZdruzitevPrimorskihSlovencevZMaticnimNarodom($year, DateTimeZone $timezone = null)
    {
        return new Holiday('zdruzitev_primorskih_slovencev_z_maticnim_narodom', new DateTime(sprintf('%s-08-17', $year)), HolidayType::OFFICIAL, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanVrnitvePrimorskeKMaticniDomovini($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_vrnitve_primorske_k_maticni_domovini', new DateTime(sprintf('%s-09-15', $year)), HolidayType::OFFICIAL, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanSuverenosti($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_suverenosti', new DateTime(sprintf('%s-10-25', $year)), HolidayType::OFFICIAL, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanReformacije($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_reformacije', new DateTime(sprintf('%s-10-31', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanSpominaNaMrtve($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_spomina_na_mrtve', new DateTime(sprintf('%s-11-01', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanRudolfaMaistra($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_rudolfa_maistra', new DateTime(sprintf('%s-11-23', $year)), HolidayType::OFFICIAL, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanSamostojnosti($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_samostojnosti', new DateTime(sprintf('%s-12-26', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }

    /**
     * @param int $year
     * @param DateTimeZone $timezone
     *
     * @return Holiday
     */
    private function getDanSamostojnostiInEnotnosti($year, DateTimeZone $timezone = null)
    {
        return new Holiday('dan_samostojnosti_in_enotnosti', new DateTime(sprintf('%s-12-26', $year)), HolidayType::OFFICIAL | HolidayType::DAY_OFF, $timezone);
    }
}
