<?php

namespace Umulmrum\Holiday\Test\Filter;

use Umulmrum\Holiday\Filter\AbstractFilter;
use Umulmrum\Holiday\Filter\FilterInverter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;

final class FilterInverterTest extends HolidayTestCase
{
    /**
     * @var HolidayList
     */
    private $holidayList;
    /**
     * @var AbstractFilter
     */
    private $innerFilter;
    /**
     * @var FilterInverter
     */
    private $filter;

    /**
     * @test
     */
    public function it_should_invert_another_filter(): void
    {
        $this->givenHolidayList();
        $this->givenInnerFilter();
        $this->givenFilterInverter();
        $this->whenFilterIsCalledOnList();
        $this->thenTheHolidayListShouldContainOnlyHolidaysRejectedByInnerFilter();
    }

    private function givenHolidayList(): void
    {
        $this->holidayList = new HolidayList([
            Holiday::create('included-in-inner-filter', '2020-01-01'),
            Holiday::create('included-in-inverse-filter', '2020-01-01'),
            Holiday::create('included-in-inner-filter', '2020-01-01'),
        ]);
    }

    private function givenFilterInverter(): void
    {
        $this->filter = new FilterInverter($this->innerFilter);
    }

    private function givenInnerFilter(): void
    {
        $this->innerFilter = new class() extends AbstractFilter {
            protected function isIncluded(Holiday $holiday): bool
            {
                return 'included-in-inner-filter' === $holiday->getName();
            }
        };
    }

    private function whenFilterIsCalledOnList(): void
    {
        $this->holidayList->filter($this->filter);
    }

    private function thenTheHolidayListShouldContainOnlyHolidaysRejectedByInnerFilter(): void
    {
        self::assertCount(1, $this->holidayList->getList());
        self::assertEquals('included-in-inverse-filter', $this->holidayList->getList()[0]->getName());
    }
}
