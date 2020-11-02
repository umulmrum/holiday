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

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;

final class NameFormatter implements HolidayFormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

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
    public function format(Holiday $holiday, array $options = []): string
    {
        return  $this->translator->translateName($holiday);
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->translator->translateName($holiday);
        }

        return $result;
    }
}
