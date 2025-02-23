<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Formatter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Formatter\MarkdownFormatter;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Test\HolidayTestCase;
use Umulmrum\Holiday\Test\TranslatorStub;
use Umulmrum\Holiday\Translator\TranslatorInterface;

final class MarkdownFormatterTest extends HolidayTestCase
{
    private MarkdownFormatter $formatter;

    private string $actualResult;

    #[DataProvider('getFormatData')]
    #[Test]
    public function it_should_format_single_values(?TranslatorInterface $translator, Holiday $holiday, string $expectedResult): void
    {
        $this->givenAFormatter($translator);
        $this->whenFormatIsCalled($holiday);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function givenAFormatter(?TranslatorInterface $translator): void
    {
        $this->formatter = new MarkdownFormatter($translator);
    }

    private function whenFormatIsCalled(Holiday $holiday): void
    {
        $this->actualResult = $this->formatter->format($holiday);
    }

    /**
     * @param string|string[] $expectedResult
     */
    private function thenAFormattedResultShouldBeReturned(array|string $expectedResult): void
    {
        self::assertEquals($expectedResult, $this->actualResult);
    }

    public static function getFormatData(): array
    {
        return [
            [
                null,
                Holiday::create('new_year', '2025-01-01', HolidayType::OTHER),
                <<<'EOF'
                    | Date       | Name     | Types |
                    |------------|----------|-------|
                    | 2025-01-01 | new_year | other |

                    EOF,
            ],
            [
                null,
                Holiday::create('christmas_eve', '2025-12-24', HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::RELIGIOUS | HolidayType::PARTIAL_ONLY),
                <<<'EOF'
                    | Date       | Name          | Types                                      |
                    |------------|---------------|--------------------------------------------|
                    | 2025-12-24 | christmas_eve | official, day_off, religious, partial_only |

                    EOF,
            ],
            [
                new TranslatorStub(),
                Holiday::create('christmas_eve', '2025-12-24', HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::RELIGIOUS | HolidayType::PARTIAL_ONLY),
                <<<'EOF'
                    | Date       | Name          | Types                                      |
                    |------------|---------------|--------------------------------------------|
                    | 2025-12-24 | Christmas Eve | Official, Day off, Religious, Partial only |

                    EOF,
            ],
        ];
    }

    #[DataProvider('getFormatListData')]
    #[Test]
    public function it_should_format_list_values(?TranslatorInterface $translator, HolidayList $holidays, string $expectedResult): void
    {
        $this->givenAFormatter($translator);
        $this->whenFormatListIsCalled($holidays);
        $this->thenAFormattedResultShouldBeReturned($expectedResult);
    }

    private function whenFormatListIsCalled(HolidayList $holidays): void
    {
        $this->actualResult = $this->formatter->formatList($holidays);
    }

    public static function getFormatListData(): array
    {
        return [
            [
                null,
                new HolidayList(),
                <<<'EOF'
                    | Date | Name | Types |
                    |------|------|-------|

                    EOF,
            ],
            [
                null,
                new HolidayList([
                    Holiday::create('new_year', '2025-01-01', HolidayType::OTHER),
                    Holiday::create('christmas_eve', '2025-12-24', HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::RELIGIOUS | HolidayType::PARTIAL_ONLY),
                ]),
                <<<'EOF'
                    | Date       | Name          | Types                                      |
                    |------------|---------------|--------------------------------------------|
                    | 2025-01-01 | new_year      | other                                      |
                    | 2025-12-24 | christmas_eve | official, day_off, religious, partial_only |

                    EOF,
            ],
            [
                new TranslatorStub(),
                new HolidayList([
                    Holiday::create('new_year', '2025-01-01', HolidayType::OTHER),
                    Holiday::create('christmas_eve', '2025-12-24', HolidayType::OFFICIAL | HolidayType::DAY_OFF | HolidayType::RELIGIOUS | HolidayType::PARTIAL_ONLY),
                ]),
                <<<'EOF'
                    | Date       | Name          | Types                                      |
                    |------------|---------------|--------------------------------------------|
                    | 2025-01-01 | New Year      | Other                                      |
                    | 2025-12-24 | Christmas Eve | Official, Day off, Religious, Partial only |

                    EOF,
            ],
        ];
    }
}
