<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test\Provider;

use DirectoryIterator;
use Generator;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use Umulmrum\Holiday\Filter\SortByDateFilter;
use Umulmrum\Holiday\Formatter\MarkdownFormatter;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Test\HolidayTestCase;

use function array_map;
use function file_get_contents;
use function preg_match_all;

final class ProviderTest extends HolidayTestCase
{
    private HolidayCalculator $calculator;
    private string $actualResult;
    private string $fixtureContent;

    #[DataProvider('provideDataForTestProviders')]
    public function testProviders(string $providerCode, string $fixturePath): void
    {
        $this->givenCalculator();
        $this->givenContentInFixturePath($fixturePath);
        $this->whenResultsAreCalculatedForEachYear($providerCode);
        $this->thenTheSameResultAsInFixtureShouldBeBuilt();
    }

    /**
     * @return int[]
     */
    private function parseYears(string $content): array
    {
        preg_match_all('/# (.*)/', $content, $matches);

        return array_map('intval', $matches[1]);
    }

    /**
     * @return Generator<array{providerCode: string, fixturePath: string}>
     */
    public static function provideDataForTestProviders(): Generator
    {
        $dirIterator = new DirectoryIterator(__DIR__ . '/Data');

        /** @var DirectoryIterator $file */
        foreach ($dirIterator as $file) {
            if ($file->isDot()) {
                continue;
            }
            preg_match('#([A-Z]{2}(-[A-Z0-9]+)?)-\w+.md#', $file->getBasename(), $matches);

            yield ['providerCode' => $matches[1], 'fixturePath' => $file->getRealPath() ?: ''];
        }
    }

    private function givenCalculator(): void
    {
        $this->calculator = new HolidayCalculator();
    }

    private function givenContentInFixturePath(string $fixturePath): void
    {
        $this->fixtureContent = file_get_contents($fixturePath) ?: throw new LogicException('File could not loaded from ' . $fixturePath);
    }

    private function whenResultsAreCalculatedForEachYear(string $providerCode): void
    {
        $years = $this->parseYears($this->fixtureContent);
        $this->actualResult = '';
        foreach ($years as $index => $year) {
            if ($index > 0) {
                $this->actualResult .= PHP_EOL;
            }
            $this->actualResult .= '# ' . $year . PHP_EOL . PHP_EOL;
            $holidays = $this->calculator->calculate($providerCode, $year);

            /** @var string $resultPart */
            $resultPart = $holidays
                ->filter(new SortByDateFilter())
                ->format(new MarkdownFormatter())
            ;
            $this->actualResult .= $resultPart;
        }
    }

    private function thenTheSameResultAsInFixtureShouldBeBuilt(): void
    {
        self::assertEquals($this->fixtureContent, $this->actualResult);
    }
}
