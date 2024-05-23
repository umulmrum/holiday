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

/**
 * IncludeHolidayNameFilter retains all holidays with the name or names passed as constructor arguments.
 */
final class IncludeHolidayNameFilter extends AbstractFilter
{
    /**
     * @var array<string, array-key>
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
            $tempHolidayNames = [
                $holidayNames,
            ];
        } elseif (\is_array($holidayNames)) {
            foreach ($holidayNames as $holidayName) {
                if (false === \is_string($holidayName)) {
                    throw new \InvalidArgumentException('Argument must be either a string or an array of strings.');
                }
            }
            $tempHolidayNames = $holidayNames;
        } else {
            throw new \InvalidArgumentException('Argument must be either a string or an array of strings.');
        }
        $this->holidayNames = \array_flip($tempHolidayNames);
    }

    /**
     * {@inheritdoc}
     */
    protected function isIncluded(Holiday $holiday): bool
    {
        return true === isset($this->holidayNames[$holiday->getName()]);
    }
}
