<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Model;

use umulmrum\Holiday\Constant\HolidayType;
use umulmrum\Holiday\Formatter\HolidayFormatterInterface;

class Holiday
{
    public const DISPLAY_DATE_FORMAT = 'Y-m-d';
    public const CREATE_DATE_FORMAT = '!Y-m-d';

    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeImmutable
     */
    private $simpleDate;
    /**
     * @var int
     */
    private $type;

    public function __construct(string $name, string $date, int $type = HolidayType::OTHER)
    {
        $this->name = $name;
        $this->simpleDate = $date;
        $this->type = $type;
    }

    public static function create(string $name, string $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, $date, $type);
    }

    public static function createFromDateTime(string $name, \DateTimeInterface $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, $date->format(static::DISPLAY_DATE_FORMAT), $type);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSimpleDate(): string
    {
        return $this->simpleDate;
    }

    public function getDate(\DateTimeZone $dateTimeZone = null): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat(static::CREATE_DATE_FORMAT, $this->simpleDate, $dateTimeZone);
    }

    public function getFormattedDate(string $format, \DateTimeZone $dateTimeZone = null): string
    {
        return $this->getDate($dateTimeZone)->format($format);
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function hasType(int $holidayType): bool
    {
        return 0 !== ($this->type & $holidayType);
    }

    public function format(HolidayFormatterInterface $formatter): string
    {
        return $formatter->format($this);
    }
}
