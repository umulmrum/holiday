<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Formatter;

use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;

use function implode;
use function max;
use function mb_str_pad;
use function mb_strlen;

final class MarkdownFormatter implements HolidayFormatterInterface
{
    private TranslatorInterface $translator;

    public function __construct(?TranslatorInterface $translator = null)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
    }

    public function format(Holiday $holiday): string
    {
        return $this->toMarkdown([$this->getLine($holiday)]);
    }

    /**
     * @return string[]
     */
    private function getLine(Holiday $holiday): array
    {
        return [
            $holiday->getSimpleDate(),
            $this->translator->translate($holiday->getName()),
            implode(', ', HolidayType::getTypeNames($this->translator, $holiday->getType())),
        ];
    }

    public function formatList(HolidayList $holidayList): array|string
    {
        $lines = [];
        foreach ($holidayList->getList() as $holiday) {
            $lines[] = $this->getLine($holiday);
        }

        return $this->toMarkdown($lines);
    }

    /**
     * @return string[]
     */
    private function getTableHeader(): array
    {
        return [
            'Date',
            'Name',
            'Types',
        ];
    }

    /**
     * @param string[][] $lines
     */
    private function toMarkdown(array $lines): string
    {
        $tableHeader = $this->getTableHeader();
        $colLengths = [
            mb_strlen($tableHeader[0]),
            mb_strlen($tableHeader[1]),
            mb_strlen($tableHeader[2]),
        ];
        foreach ($lines as $line) {
            foreach ([0, 1, 2] as $col) {
                $colLengths[$col] = max($colLengths[$col], mb_strlen($line[$col]));
            }
        }

        $result = $this->writeTableLine($tableHeader, $colLengths);
        $result .= $this->writeTableLine(['-', '-', '-'], $colLengths, '-');
        foreach ($lines as $line) {
            $result .= $this->writeTableLine($line, $colLengths);
        }

        return $result;
    }

    /**
     * @param string[] $cols
     * @param int[]    $colLengths
     */
    private function writeTableLine(array $cols, array $colLengths, string $filler = ' '): string
    {
        $line = '|' . $filler;
        foreach ($cols as $index => $col) {
            if ($index > 0) {
                $line .= $filler . '|' . $filler;
            }
            $line .= mb_str_pad($col, $colLengths[$index], $filler);
        }
        $line .= $filler . '|' . PHP_EOL;

        return $line;
    }
}
