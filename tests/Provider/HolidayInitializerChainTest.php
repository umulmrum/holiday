<?php

namespace umulmrum\Holiday\Provider;

use Prophecy\Prophecy\ObjectProphecy;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\HolidayTestCase;

class HolidayInitializerChainTest extends HolidayTestCase
{
    /**
     * @var HolidayInitializerChain
     */
    private $holidayInitializerChain;
    /**
     * @var HolidayCalculatorInterface|ObjectProphecy
     */
    private $holidayCalculatorMock;
    /**
     * @var ObjectProphecy[]
     */
    private $holidayInitializersMocks;
    /**
     * @var HolidayInitializerInterface[]
     */
    private $revealedHolidayInitializersMocks;

    /**
     * @test
     * @dataProvider getData
     *
     * @param int $count
     */
    public function it_should_initialize_the_passed_chain($count)
    {
        $this->givenMockedInitializers($count);
        $this->givenAHolidayInitializerChain();
        $this->whenInitializeHolidaysIsCalled();
        $this->thenAllGivenInitializersShouldRun();
    }

    private function givenAHolidayInitializerChain()
    {
        $this->holidayInitializerChain = new HolidayInitializerChain($this->revealedHolidayInitializersMocks);
    }

    /**
     * @param int $count
     */
    private function givenMockedInitializers($count)
    {
        $this->holidayInitializersMocks = [];
        $this->revealedHolidayInitializersMocks = [];
        for ($i = 0; $i < $count; ++$i) {
            $this->holidayInitializersMocks[] = $this->prophesize('\umulmrum\Holiday\Provider\HolidayInitializerInterface');
        }
        foreach ($this->holidayInitializersMocks as $holidayInitializerMock) {
            $this->revealedHolidayInitializersMocks[] = $holidayInitializerMock->reveal();
        }
    }

    private function whenInitializeHolidaysIsCalled()
    {
        $this->holidayCalculatorMock = $this->prophesize('\umulmrum\Holiday\Calculator\HolidayCalculator');
        $this->holidayInitializerChain->initializeHolidays($this->holidayCalculatorMock->reveal());
    }

    private function thenAllGivenInitializersShouldRun()
    {
        foreach ($this->holidayInitializersMocks as $holidayInitializerMock) {
            $holidayInitializerMock->initializeHolidays($this->holidayCalculatorMock)->shouldHaveBeenCalled();
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                0,
            ],
            [
                1,
            ],
            [
                2,
            ],
            [
                7,
            ],
        ];
    }
}
