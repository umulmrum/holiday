<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Test\Translator;

use Prophecy\Argument;
use Symfony\Contracts\Translation\TranslatorInterface;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Test\HolidayTestCase;
use umulmrum\Holiday\Translator\SymfonyBridgeTranslator;

final class SymfonyBridgeTranslatorTest extends HolidayTestCase
{
    /**
     * @var SymfonyBridgeTranslator
     */
    private $translator;
    /**
     * @var TranslatorInterface
     */
    private $symfonyTranslator;
    /**
     * @var string
     */
    private $actualResult;

    /**
     * @test
     * @dataProvider getTranslateNameData
     */
    public function it_should_return_symfony_translations(string $name): void
    {
        $this->givenASymfonyBridgeTranslator();
        $this->whenTranslateNameIsCalled($name);
        $this->thenTheSymfonyTranslatorShouldBeCalled($name);
        $this->thenTheStringTranslatedBySymfonyShouldBeReturned();
    }

    private function givenASymfonyBridgeTranslator(): void
    {
        $this->symfonyTranslator = $this->prophesize(TranslatorInterface::class);
        $this->symfonyTranslator->trans(Argument::any(), Argument::any(), Argument::any(), Argument::any())->willReturn('translatedString');
        $this->translator = new SymfonyBridgeTranslator($this->symfonyTranslator->reveal());
    }

    private function whenTranslateNameIsCalled(string $name): void
    {
        $this->actualResult = $this->translator->translateName(Holiday::create($name, '2016-01-01'));
    }

    private function thenTheSymfonyTranslatorShouldBeCalled(string $name): void
    {
        $this->symfonyTranslator->trans($name, [], 'umulmrum_holiday')->shouldHaveBeenCalled();
    }

    private function thenTheStringTranslatedBySymfonyShouldBeReturned(): void
    {
        self::assertEquals('translatedString', $this->actualResult);
    }

    public function getTranslateNameData(): array
    {
        return [
            [
                'name',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider getTranslateData
     */
    public function it_should_send_arbitrary_strings_to_the_translator(string $name): void
    {
        $this->givenASymfonyBridgeTranslator();
        $this->whenTranslateIsCalled($name);
        $this->thenTheSymfonyTranslatorShouldBeCalled($name);
        $this->thenTheStringTranslatedBySymfonyShouldBeReturned();
    }

    private function whenTranslateIsCalled(string $name): void
    {
        $this->actualResult = $this->translator->translate($name);
    }

    public function getTranslateData(): array
    {
        return [
            [
                'name',
            ],
        ];
    }
}
