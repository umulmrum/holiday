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
use ReflectionClass;
use Umulmrum\Holiday\Constant\HolidayName;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Translator\Translator;

use function implode;

final class TranslatorTest extends HolidayTestCase
{
    private Translator $translator;
    private string $actualResult;

    /** @var string[] */
    private array $notFoundTranslations;

    #[DataProvider('getTranslateNameData')]
    #[Test]
    public function it_should_translate(string $key, ?string $locale, string $expectedResult): void
    {
        $this->givenATranslator();
        $this->whenTranslateNameIsCalled($key, $locale);
        $this->thenTheTranslatedStringShouldBeReturned($expectedResult);
    }

    private function givenATranslator(): void
    {
        $this->translator = new Translator('en');
    }

    private function whenTranslateNameIsCalled(string $name, ?string $locale): void
    {
        $this->actualResult = $this->translator->translateName(Holiday::create($name, '2016-01-01'), $locale);
    }

    private function thenTheTranslatedStringShouldBeReturned(string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public static function getTranslateNameData(): array
    {
        return [
            [
                'sunday',
                'en',
                'Sunday',
            ],
            [
                'sunday',
                'en_US',
                'Sunday',
            ],
            [
                'sunday',
                'de',
                'Sonntag',
            ],
            [
                'sunday',
                'unknown',
                'Sunday',
            ],
            [
                'sunday',
                null,
                'Sunday',
            ],
            [
                'unknown',
                'en',
                '',
            ],
            [
                'unknown',
                'en_US',
                '',
            ],
        ];
    }

    #[Test]
    public function it_should_be_able_to_translate_all_holiday_names(): void
    {
        $this->givenATranslator();
        $this->whenTranslateIsCalledForAllKnownHolidayNames();
        $this->thenAllTranslationsShouldBeFoundAndNotEmpty();
    }

    private function whenTranslateIsCalledForAllKnownHolidayNames(): void
    {
        $holidayNameClass = new ReflectionClass(HolidayName::class);
        $this->notFoundTranslations = [];
        foreach ($holidayNameClass->getConstants() as $name => $value) {
            if ($name === 'SUFFIX_COMPENSATORY') {
                continue;
            }
            if ($value === $this->translator->translate($value, 'en')) {
                $this->notFoundTranslations[] = $value;
            }
        }
    }

    private function thenAllTranslationsShouldBeFoundAndNotEmpty(): void
    {
        self::assertEmpty(
            $this->notFoundTranslations,
            'Translations for the following holiday names not found. Please add them to res/trans/umulmrum_holiday.en.php: '
            . implode(', ', $this->notFoundTranslations)
        );
    }
}
