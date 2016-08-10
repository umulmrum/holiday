<?php

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class DateFormatter implements HolidayFormatterInterface
{
    const PARAM_FORMAT = 'date_formatter.format';
    /**
     * @var string
     */
    private $defaultFormat;

    /**
     * @param string $defaultFormat
     */
    public function __construct($defaultFormat = 'Y-m-d')
    {
        $this->defaultFormat = $defaultFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = [])
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

        /**
         * @var Holiday $holiday
         */
        foreach ($holidayList->getFlatArray() as $holiday) {
            $result[] = $holiday->getFormattedDate($format);
        }

        return $result;
    }

    /**
     * @param array $options
     *
     * @return string
     */
    private function getFormat(array $options)
    {
        if (isset($options[self::PARAM_FORMAT])) {
            return $options[self::PARAM_FORMAT];
        } else {
            return $this->defaultFormat;
        }
    }
}
