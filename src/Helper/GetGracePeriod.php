<?php

namespace umulmrum\Holiday\Helper;

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\Provider\HolidayProviderInterface;

final class GetGracePeriod
{
    /**
     * @var HolidayCalculatorInterface
     */
    private $holidayCalculator;

    public function __construct(HolidayCalculatorInterface $holidayCalculator = null)
    {
        $this->holidayCalculator = $holidayCalculator ?? new HolidayCalculator();
    }

    /**
     * @param string|HolidayProviderInterface|string[]|HolidayProviderInterface[] $holidayProviders
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke($holidayProviders, \DateTimeInterface $firstDay, int $numberOfDays): \DateTimeInterface
    {
        $workingDate = clone $firstDay;
        $year = (int) $workingDate->format('Y');
        $holidays = $this->holidayCalculator->calculate($holidayProviders, $year);
//        $workingDate = \DateTime::createFromFormat('!Y-m-d', $firstDay->format('Y-m-d'));
        $remainingDays = $numberOfDays;
        $interval = new \DateInterval('P1D');
        do {
            if ($holidays->isHoliday($workingDate)) {
                $numberOfDays++;
                if ($remainingDays === 0) {
                    $remainingDays = 1;
                }
            } else {
                $remainingDays--;
            }
            $workingDate = $workingDate->add($interval);
            $newYear = (int) $workingDate->format('Y');
            if ($newYear !== $year) {
                $holidays = $this->holidayCalculator->calculate($holidayProviders, $newYear);
            }
        } while($remainingDays > 0);

        return $workingDate;
    }
}
