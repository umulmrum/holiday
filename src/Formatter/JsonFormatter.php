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

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;

final class JsonFormatter implements HolidayFormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var int
     */
    private $jsonOptions;
    /**
     * @var \DateTimeZone|null
     */
    private $dateTimeZone;

    public function __construct(TranslatorInterface $translator = null, int $jsonOptions = 0, \DateTimeZone $dateTimeZone = null)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
        $this->jsonOptions = $jsonOptions;
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = []): string
    {
        return \json_encode($this->getEvent($holiday), $this->jsonOptions);
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

        return \json_encode($result, $this->jsonOptions);
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
            'formattedType' => $this->getTypeNames($this->getTypeList($holiday->getType())),
        ];
    }

    /**
     * @return int[]
     */
    private function getTypeList(int $type): array
    {
        $typeList = [];

        $counter = 1;
        while (0 !== $type) {
            if (0 !== ($type & $counter)) {
                $typeList[] = $counter;
            }
            $type &= ~$counter;
            $counter <<= 1;
        }
        if (0 === \count($typeList)) {
            $typeList[] = HolidayType::OTHER;
        }

        return $typeList;
    }

    /**
     * @param int[] $typeList
     *
     * @return string[]
     */
    private function getTypeNames(array $typeList): array
    {
        $translatedList = [];
        foreach ($typeList as $type) {
            $translatedList[] = $this->translator->translate(HolidayType::$NAME[$type]);
        }

        return $translatedList;
    }
}
