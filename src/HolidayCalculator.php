<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday;

use Umulmrum\Holiday\Interpreter\HolidayProviderInterpreterTrait;
use Umulmrum\Holiday\Interpreter\YearInterpreterTrait;
use Umulmrum\Holiday\Model\HolidayList;

final class HolidayCalculator implements HolidayCalculatorInterface
{
    use HolidayProviderInterpreterTrait;
    use YearInterpreterTrait;

    /**
     * {@inheritdoc}
     */
    public function calculate($holidayProviders, $years): HolidayList
    {
        $finalHolidayProviders = $this->interpretHolidayProviders($holidayProviders);
        $finalYears = $this->interpretYears($years);

        $holidays = new HolidayList();
        foreach ($finalHolidayProviders as $holidayProvider) {
            foreach ($finalYears as $year) {
                $holidays->addAll($holidayProvider->calculateHolidaysForYear($year));
            }
        }

        return $holidays;
    }
}
