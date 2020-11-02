<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Translator;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;
use Umulmrum\Holiday\Translator\SymfonyBridgeTranslator;

final class SymfonyBridgeTranslatorTest extends HolidayTestCase
{
    /**
     * @var SymfonyBridgeTranslator
     */
    private $translator;
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
        $this->thenTheStringTranslatedBySymfonyShouldBeReturned();
    }

    private function givenASymfonyBridgeTranslator(): void
    {
        $this->translator = new SymfonyBridgeTranslator(new TranslatorStub());
    }

    private function whenTranslateNameIsCalled(string $name): void
    {
        $this->actualResult = $this->translator->translateName(Holiday::create($name, '2016-01-01'));
    }

    private function thenTheStringTranslatedBySymfonyShouldBeReturned(): void
    {
        self::assertEquals('Such name', $this->actualResult);
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
