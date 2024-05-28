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
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;

use function json_encode;

final class JsonFormatter implements HolidayFormatterInterface
{
    private TranslatorInterface $translator;

    public function __construct(?TranslatorInterface $translator = null, private readonly int $jsonOptions = 0, private readonly ?DateTimeZone $dateTimeZone = null)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
    }

    public function format(Holiday $holiday): string
    {
        return json_encode($this->getEvent($holiday), $this->jsonOptions) ?: '';
    }

    public function formatList(HolidayList $holidayList): array|string
    {
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->getEvent($holiday);
        }

        return json_encode($result, $this->jsonOptions) ?: '';
    }

    /**
     * @return mixed[]
     */
    private function getEvent(Holiday $holiday): array
    {
        $date = $holiday->getDate($this->dateTimeZone);

        return [
            'name' => $holiday->getName(),
            'translatedName' => $this->translator->translateName($holiday),
            'timestamp' => $date->getTimestamp(),
            'formattedDate' => $date->format('Ymd\THis\ZO'),
            'type' => $holiday->getType(),
            'formattedType' => HolidayType::getTypeNames($this->translator, $holiday->getType()),
        ];
    }
}
