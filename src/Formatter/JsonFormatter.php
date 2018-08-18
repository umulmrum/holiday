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

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Translator\NullTranslator;
use umulmrum\Holiday\Translator\TranslatorInterface;

class JsonFormatter implements HolidayFormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var int
     */
    private $jsonOptions;

    public function __construct(TranslatorInterface $translator = null, int $jsonOptions = 0)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
        $this->jsonOptions = $jsonOptions;
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

    private function getEvent(Holiday $holiday): array
    {
        return [
            'name' => $holiday->getName(),
            'translatedName' => $this->translator->translateName($holiday),
            'timestamp' => $holiday->getTimestamp(),
            'formattedDate' => $holiday->getFormattedDate('Ymd\THis\ZO'),
            'type' => $holiday->getType(),
            'formattedType' => $this->getTypeNames($this->getTypeList($holiday->getType())),
        ];
    }

    private function getTypeList(int $type): array
    {
        $typeList = [];

        $counter = 1;
        while ($type !== 0) {
            if (($type & $counter) !== 0) {
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

    private function getTypeNames(array $typeList): array
    {
        $translatedList = [];
        foreach ($typeList as $type) {
            $translatedList[] = $this->translator->translate(HolidayType::$NAME[$type]);
        }

        return $translatedList;
    }
}
