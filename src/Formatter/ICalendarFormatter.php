<?php

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Translator\NullTranslator;
use umulmrum\Holiday\Translator\TranslatorInterface;

class ICalendarFormatter implements HolidayFormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface|null $translator
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = [])
    {
        return $this->getEvent($holiday);
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];
        /**
         * @var Holiday $holiday
         */
        foreach ($holidayList->getFlatArray() as $holiday) {
            $result[] = $this->getEvent($holiday);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return implode("\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:TODO',
            'CALSCALE:GREGORIAN',
        ])."\n";
    }

    /**
     * @param Holiday $holiday
     *
     * @return array
     */
    private function getEvent(Holiday $holiday)
    {
        return implode("\n", [
            'BEGIN:VEVENT',
            'UID:TODO',
            'DTSTAMP:TODO',
            'SUMMARY:'.$this->translator->translateName($holiday),
            'DTSTART:VALUE=DATE:'.$holiday->getFormattedDate('Ymd'),
            'END:VEVENT',
        ]);
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return 'END:VCALENDAR'."\n";
    }
}
