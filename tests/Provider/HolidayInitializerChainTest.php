<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Provider;

use Prophecy\Prophecy\ObjectProphecy;
use umulmrum\Holiday\Calculator\HolidayCalculatorInterface;
use umulmrum\Holiday\HolidayTestCase;
use umulmrum\Holiday\Calculator\HolidayCalculator;

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
     * @var HolidayInitializerInterface[]|ObjectProphecy[]
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
            $this->holidayInitializersMocks[] = $this->prophesize(HolidayInitializerInterface::class);
        }
        foreach ($this->holidayInitializersMocks as $holidayInitializerMock) {
            $this->revealedHolidayInitializersMocks[] = $holidayInitializerMock->reveal();
        }
    }

    private function whenInitializeHolidaysIsCalled()
    {
        $this->holidayCalculatorMock = $this->prophesize(HolidayCalculator::class);
        $this->holidayInitializerChain->initializeHolidays($this->holidayCalculatorMock->reveal());
    }

    private function thenAllGivenInitializersShouldRun()
    {
        if (0 === count($this->holidayInitializersMocks)) {
            $this->assertTrue(true);

            return;
        }
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
