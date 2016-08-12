<?php

namespace umulmrum\Holiday\Formatter;

use DateTime;
use DateTimeZone;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Translator\NullTranslator;
use umulmrum\Holiday\Translator\TranslatorInterface;

class ICalendarFormatter implements HolidayFormatterInterface
{
    const LINE_ENDING = "\r\n";
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
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->getEvent($holiday);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return implode(self::LINE_ENDING, [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:umulmrum/holiday',
            'CALSCALE:GREGORIAN',
        ]).self::LINE_ENDING;
    }

    /**
     * @param Holiday $holiday
     *
     * @return array
     */
    private function getEvent(Holiday $holiday)
    {
        $dtstamp = new DateTime('now', new DateTimeZone('UTC'));

        return implode(self::LINE_ENDING, [
            'BEGIN:VEVENT',
            sprintf('UID:%s-%s', $holiday->getName(), $holiday->getFormattedDate('Y-m-d')),
            sprintf('DTSTAMP:%s', $dtstamp->format('Ymd\TGis\ZO')),
            sprintf('CREATED:%s', $dtstamp->format('Ymd\TGis\ZO')),
            'SUMMARY:'.$this->translator->translateName($holiday),
            'DTSTART;VALUE=DATE:'.$holiday->getFormattedDate('Ymd'),
            'END:VEVENT',
        ]);
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return 'END:VCALENDAR'.self::LINE_ENDING;
    }
}
