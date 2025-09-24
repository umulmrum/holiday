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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;
use Umulmrum\Holiday\Translator\SymfonyBridgeTranslator;

final class SymfonyBridgeTranslatorTest extends HolidayTestCase
{
    private SymfonyBridgeTranslator $translator;
    private string $actualResult;

    #[DataProvider('getTranslateNameData')]
    #[Test]
    public function itShouldReturnSymfonyTranslations(string $name): void
    {
        $this->givenASymfonyBridgeTranslator();
        $this->whenTranslateNameIsCalled($name);
        $this->thenTheStringTranslatedBySymfonyShouldBeReturned();
    }

    public static function getTranslateNameData(): array
    {
        return [
            [
                'name',
            ],
        ];
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

    #[DataProvider('getTranslateData')]
    #[Test]
    public function itShouldSendArbitraryStringsToTheTranslator(string $name): void
    {
        $this->givenASymfonyBridgeTranslator();
        $this->whenTranslateIsCalled($name);
        $this->thenTheStringTranslatedBySymfonyShouldBeReturned();
    }

    public static function getTranslateData(): array
    {
        return [
            [
                'name',
            ],
        ];
    }

    private function whenTranslateIsCalled(string $name): void
    {
        $this->actualResult = $this->translator->translate($name);
    }
}
