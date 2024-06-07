<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Compensatory;

use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

interface CompensatoryDaysCalculatorInterface
{
    /**
     * Adds all compensatory days to the passed $holidays, according to the implementation's rule.
     * The $holidays must all be within $year.
     */
    public function addAll(HolidayList $holidays, HolidayProviderInterface $holidayProvider, int $year): void;
}
