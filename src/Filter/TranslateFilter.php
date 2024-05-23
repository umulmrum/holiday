<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Filter;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\TranslatorInterface;

/**
 * TranslateFilter translates the names of all elements in the filtered HolidayList by using the translator passed as
 * constructor argument.
 */
final readonly class TranslateFilter implements HolidayFilterInterface
{
    public function __construct(private TranslatorInterface $translator) {}

    public function filter(HolidayList $holidayList): void
    {
        foreach ($holidayList->getList() as $index => $holiday) {
            $holidayList->replaceByIndex(
                $index,
                Holiday::create(
                    $this->translator->translate($holiday->getName()),
                    $holiday->getSimpleDate(),
                    $holiday->getType()
                )
            );
        }
    }
}
