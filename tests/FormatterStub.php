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

use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

use function array_map;
use function implode;
use function sprintf;

final class FormatterStub implements HolidayFormatterInterface
{
    public function format(Holiday $holiday): string
    {
        return sprintf('%s|%s|%s', $holiday->getName(), $holiday->getSimpleDate(), $holiday->getType());
    }

    public function formatList(HolidayList $holidayList): array|string
    {
        return implode(';', array_map($this->format(...), $holidayList->getList()));
    }
}
