<?php

namespace umulmrum\Holiday\Formatter;

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
            'formattedDate' => $holiday->getFormattedDate('Ymd\TGis\ZO'),
            'type' => $holiday->getType(),
            // TODO format type (with translation)
        ];
    }
}
