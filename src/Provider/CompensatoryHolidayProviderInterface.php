<?php

namespace Umulmrum\Holiday\Provider;

use Umulmrum\Holiday\Compensatory\CompensatoryDaysCalculatorInterface;

interface CompensatoryHolidayProviderInterface extends HolidayProviderInterface
{
    /**
     * @return CompensatoryDaysCalculatorInterface[]
     */
    public function getCompensatoryDaysCalculators(int $year): array;
}
