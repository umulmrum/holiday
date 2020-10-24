<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class DateFormatter implements HolidayFormatterInterface
{
    public const PARAM_FORMAT = 'date_formatter.format';

    /**
     * @var string
     */
    private $defaultFormat;

    public function __construct(string $defaultFormat = 'Y-m-d')
    {
        $this->defaultFormat = $defaultFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = []): string
    {
        return $holiday->getFormattedDate($this->getFormat($options));
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $format = $this->getFormat($options);
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $holiday->getFormattedDate($format);
        }

        return $result;
    }

    private function getFormat(array $options): string
    {
        if (isset($options[self::PARAM_FORMAT])) {
            return $options[self::PARAM_FORMAT];
        } else {
            return $this->defaultFormat;
        }
    }
}
