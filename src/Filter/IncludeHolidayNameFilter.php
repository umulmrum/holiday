<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\Holiday;

final class IncludeHolidayNameFilter extends AbstractFilter
{
    /**
     * @var string|string[]
     */
    private $holidayNames;

    /**
     * @param string|string[] $holidayNames
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($holidayNames)
    {
        if (true === \is_string($holidayNames)) {
            $this->holidayNames = [
                $holidayNames,
            ];
        } elseif (true === \is_array($holidayNames)) {
            $this->holidayNames = $holidayNames;
        } else {
            throw new \InvalidArgumentException('First argument must be either a string or an array of strings.');
        }
        $this->holidayNames = \array_flip($this->holidayNames);
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        return true === isset($this->holidayNames[$holiday->getName()]);
    }
}
