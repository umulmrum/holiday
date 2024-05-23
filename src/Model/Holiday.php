<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Model;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;
use Umulmrum\Holiday\Provider\DateCreatorTrait;

class Holiday
{
    use DateCreatorTrait;

    /** @var string */
    public const DISPLAY_DATE_FORMAT = 'Y-m-d';

    /** @var string */
    public const CREATE_DATE_FORMAT = '!Y-m-d';

    public function __construct(private string $name, private string $simpleDate, private int $type = HolidayType::OTHER) {}

    public static function create(string $name, string $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, $date, $type);
    }

    public static function createFromDateTime(string $name, DateTimeInterface $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, $date->format((string) static::DISPLAY_DATE_FORMAT), $type);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSimpleDate(): string
    {
        return $this->simpleDate;
    }

    public function getDate(?DateTimeZone $dateTimeZone = null): DateTimeImmutable
    {
        // @phpstan-ignore-next-line
        return DateTimeImmutable::createFromFormat((string) static::CREATE_DATE_FORMAT, $this->simpleDate, $dateTimeZone);
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function hasType(int $holidayType): bool
    {
        return (0 !== ($this->type & $holidayType))
            || (HolidayType::OTHER === $this->type && HolidayType::OTHER === $holidayType);
    }

    public function format(HolidayFormatterInterface $formatter): string
    {
        return $formatter->format($this);
    }
}
