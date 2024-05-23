<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Formatter;

use DateTimeZone;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

final class DateFormatter implements HolidayFormatterInterface
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var DateTimeZone|null
     */
    private $dateTimeZone;

    public function __construct(string $format = Holiday::DISPLAY_DATE_FORMAT, ?DateTimeZone $dateTimeZone = null)
    {
        $this->format = $format;
        $this->dateTimeZone = $dateTimeZone;
    }

    public function format(Holiday $holiday): string
    {
        if (Holiday::DISPLAY_DATE_FORMAT === $this->format) {
            return $holiday->getSimpleDate();
        }

        return $holiday->getDate($this->dateTimeZone)->format($this->format);
    }

    public function formatList(HolidayList $holidayList)
    {
        $result = [];
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->format($holiday);
        }

        return $result;
    }
}
