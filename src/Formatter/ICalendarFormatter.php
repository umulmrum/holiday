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

use Umulmrum\Holiday\Helper\DateProvider;
use Umulmrum\Holiday\Helper\DateProviderInterface;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;

final class ICalendarFormatter implements HolidayFormatterInterface
{
    public const LINE_ENDING = "\r\n";

    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var DateProviderInterface
     */
    private $dateProvider;

    public function __construct(TranslatorInterface $translator = null, DateProviderInterface $dateProvider = null)
    {
        $this->translator = $translator ?? new NullTranslator();
        $this->dateProvider = $dateProvider ?? new DateProvider();
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = []): string
    {
        return $this->getEvent($holiday);
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        $result[] = $this->getHeader();
        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->getEvent($holiday);
        }
        $result[] = $this->getFooter();

        return \implode(self::LINE_ENDING, $result).self::LINE_ENDING;
    }

    public function getHeader(): string
    {
        return implode(self::LINE_ENDING, [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:umulmrum/holiday',
            'CALSCALE:GREGORIAN',
        ]);
    }

    private function getEvent(Holiday $holiday): string
    {
        $dtstamp = $this->dateProvider->getCurrentDate();

        return implode(self::LINE_ENDING, [
            'BEGIN:VEVENT',
            sprintf('UID:%s-%s', $holiday->getName(), $holiday->getSimpleDate()),
            sprintf('DTSTAMP:%s', $dtstamp->format('Ymd\THis\ZO')),
            sprintf('CREATED:%s', $dtstamp->format('Ymd\THis\ZO')),
            'SUMMARY:'.$this->translator->translateName($holiday),
            'DTSTART;VALUE=DATE:'.$holiday->getDate()->format('Ymd'),
            'END:VEVENT',
        ]);
    }

    public function getFooter(): string
    {
        return 'END:VCALENDAR';
    }
}
