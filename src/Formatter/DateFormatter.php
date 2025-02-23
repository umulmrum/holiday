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

final readonly class DateFormatter implements HolidayFormatterInterface
{
    public function __construct(private string $format = Holiday::DISPLAY_DATE_FORMAT, private ?DateTimeZone $dateTimeZone = null) {}

    public function format(Holiday $holiday): string
    {
        if (Holiday::DISPLAY_DATE_FORMAT === $this->format) {
            return $holiday->getSimpleDate();
        }

        return $holiday->getDate($this->dateTimeZone)->format($this->format);
    }

    /**
     * @return string[]
     */
    public function formatList(HolidayList $holidayList): array
    {
        $result = [];
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->format($holiday);
        }

        return $result;
    }
}
