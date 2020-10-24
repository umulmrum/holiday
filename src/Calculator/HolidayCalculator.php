<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Calculator;

use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

class HolidayCalculator implements HolidayCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear($holidayProviders, int $year): HolidayList
    {
        $finalHolidayProviders = $this->interpretHolidayProviders($holidayProviders);

        $holidays = new HolidayList();
        foreach ($finalHolidayProviders as $holidayProvider) {
            $holidays->addAll($holidayProvider->calculateHolidaysForYear($year));
        }

        return $holidays;
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     *
     * @return HolidayProviderInterface[]
     *
     * @throws \InvalidArgumentException
     */
    private function interpretHolidayProviders($holidayProviders): array
    {
        $finalHolidayProviders = [];

        if (false === \is_array($holidayProviders)) {
            $holidayProviders = [
                $holidayProviders,
            ];
        }
        foreach ($holidayProviders as $holidayProviderName) {
            if (true === \is_string($holidayProviderName)) {
                $finalHolidayProviders[] = $this->getHolidayProviderFromClassString($holidayProviderName);
            } else {
                if (false === $holidayProviderName instanceof HolidayProviderInterface) {
                    $argumentType = (true === \is_object($holidayProviderName)) ? \get_class($holidayProviderName) : 'scalar';
                    throw new \InvalidArgumentException(\sprintf('First argument needs to be either of type HolidayProviderInterface or a string containing
                        the fully qualified name of a class implementing HolidayProviderInterface 
                        (or an array containing a mixture of both). Got %s instead.', $argumentType));
                }
                $finalHolidayProviders[] = $holidayProviderName;
            }
        }

        return $finalHolidayProviders;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function getHolidayProviderFromClassString(string $classString): HolidayProviderInterface
    {
        if (false === \class_exists($classString)) {
            throw new \InvalidArgumentException(sprintf('Class does not exist: %s', $classString));
        }
        $holidayProvider = new $classString();
        if (false === $holidayProvider instanceof HolidayProviderInterface) {
            throw new \InvalidArgumentException(sprintf('Class does not implement HolidayProviderInterface: %s', $classString));
        }

        return $holidayProvider;
    }
}
