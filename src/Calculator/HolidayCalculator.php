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
     * @var HolidayProviderInterface[]
     */
    private $holidayProviders = [];

    /**
     * @param string[]|string|HolidayProviderInterface[]|HolidayProviderInterface $holidayProviders
     *
     * @throws \InvalidArgumentException if $holidayProviders has an invalid type
     */
    public function __construct($holidayProviders = [])
    {
        if (false === \is_array($holidayProviders)) {
            $holidayProviders = [
                $holidayProviders,
            ];
        } elseif (0 === \count($holidayProviders)) {
            throw new \InvalidArgumentException('At least one holiday provider must be given.');
        }
        foreach ($holidayProviders as $holidayProviderName) {
            if (true === \is_string($holidayProviderName)) {
                $this->holidayProviders[] = $this->getHolidayProviderFromClassString($holidayProviderName);
            } else {
                if (false === $holidayProviderName instanceof HolidayProviderInterface) {
                    $argumentType = (true === \is_object($holidayProviderName)) ? \get_class($holidayProviderName) : 'scalar';
                    throw new \InvalidArgumentException(sprintf(
                        'First argument needs to be either of type HolidayProviderInterface or a string containing
                        the fully qualified name of a class implementing HolidayProviderInterface 
                        (or an array containing a mixture of both). Got %s instead.', $argumentType));
                }
                $this->holidayProviders[] = $holidayProviderName;
            }
        }
    }

    /**
     * @param string $classString
     *
     * @return HolidayProviderInterface
     *
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

    /**
     * {@inheritdoc}
     */
    public function calculateHolidaysForYear(int $year, \DateTimeZone $timezone = null): HolidayList
    {
        $holidays = new HolidayList();
        foreach ($this->holidayProviders as $holidayProvider) {
            $holidays->addAll($holidayProvider->calculateHolidaysForYear($year, $timezone));
        }

        return $holidays;
    }
}
