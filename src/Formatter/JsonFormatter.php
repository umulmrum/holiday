<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
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
        return json_encode($this->getEvent($holiday), JSON_PRETTY_PRINT);
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

        return json_encode($result, JSON_PRETTY_PRINT);
    }

    /**
     * @param Holiday $holiday
     *
     * @return array
     */
    private function getEvent(Holiday $holiday)
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

    /**
     * @param int $type
     *
     * @return array
     */
    private function getTypeList($type)
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
        if (0 === count($typeList)) {
            $typeList[] = HolidayType::OTHER;
        }

        return $typeList;
    }

    /**
     * @param int[] $typeList
     *
     * @return string[]
     */
    private function getTypeNames(array $typeList)
    {
        $translatedList = [];
        foreach ($typeList as $type) {
            $translatedList[] = $this->translator->translate(HolidayType::$NAME[$type]);
        }

        return $translatedList;
    }
}
