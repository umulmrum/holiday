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

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;

final class DateFormatter implements HolidayFormatterInterface
{
    public const PARAM_FORMAT = 'date_formatter.format';
    public const PARAM_DATETIMEZONE = 'date_formatter.datetimezone';

    /**
     * @var string
     */
    private $defaultFormat;

    public function __construct(string $defaultFormat = Holiday::DISPLAY_DATE_FORMAT)
    {
        $this->defaultFormat = $defaultFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = []): string
    {
        $format = $this->getFormat($options);
        if (Holiday::DISPLAY_DATE_FORMAT === $format) {
            return $holiday->getSimpleDate();
        }

        return $holiday->getDate($options[self::PARAM_DATETIMEZONE] ?? null)->format($format);
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->format($holiday, $options);
        }

        return $result;
    }

    private function getFormat(array $options): string
    {
        return $options[self::PARAM_FORMAT] ?? $this->defaultFormat;
    }
}
