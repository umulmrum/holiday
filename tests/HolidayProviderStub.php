<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final class HolidayProviderStub implements HolidayProviderInterface
{
    public function calculateHolidaysForYear(int $year): HolidayList
    {
        return new HolidayList([
            Holiday::create('name1', "{$year}-01-02"),
            Holiday::create('name2', "{$year}-07-07"),
        ]);
    }
}
