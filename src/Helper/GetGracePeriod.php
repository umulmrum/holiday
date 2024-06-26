<?php

namespace Umulmrum\Holiday\Helper;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\HolidayCalculatorInterface;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

final readonly class GetGracePeriod
{
    public function __construct(private HolidayCalculatorInterface $holidayCalculator = new HolidayCalculator()) {}

    /**
     * Returns the date that lies $numberOfDays in the future of $firstDay, prolonged by all holidays generated from
     * $holidayProviders.
     *
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $holidayProviders
     *
     * @throws InvalidArgumentException
     */
    public function __invoke($holidayProviders, DateTimeImmutable $firstDay, int $numberOfDays): DateTimeInterface
    {
        $workingDate = clone $firstDay;
        $year = (int) $workingDate->format('Y');
        $holidays = $this->holidayCalculator->calculate($holidayProviders, $year);
        $remainingDays = $numberOfDays;
        $interval = new DateInterval('P1D');
        do {
            if ($holidays->isHoliday($workingDate)) {
                ++$numberOfDays;
                if (0 === $remainingDays) {
                    $remainingDays = 1;
                }
            } else {
                --$remainingDays;
            }
            $workingDate = $workingDate->add($interval);
            $newYear = (int) $workingDate->format('Y');
            if ($newYear !== $year) {
                $holidays = $this->holidayCalculator->calculate($holidayProviders, $newYear);
            }
        } while ($remainingDays > 0);

        return $firstDay->add(new DateInterval('P' . $numberOfDays . 'D'));
    }
}
