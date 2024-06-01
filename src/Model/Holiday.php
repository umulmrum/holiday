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
use InvalidArgumentException;
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;
use Umulmrum\Holiday\Provider\DateCreatorTrait;

use function mb_strlen;
use function preg_match;

class Holiday
{
    use DateCreatorTrait;

    /** @var string */
    public const DISPLAY_DATE_FORMAT = 'Y-m-d';

    /** @var string */
    public const CREATE_DATE_FORMAT = '!Y-m-d';

    public function __construct(
        private readonly string $name,
        private readonly string $simpleDate,
        private readonly int $type = HolidayType::OTHER,
    ) {
        if ($this->name === '') {
            throw new InvalidArgumentException('Holiday name must not be empty.');
        }
        if (mb_strlen($this->simpleDate) !== 10 || preg_match('#^\d{4}-\d{2}-\d{2}$#', $this->simpleDate) !== 1) {
            throw new InvalidArgumentException('Date must be in format YYYY-MM-DD, got ' . $this->simpleDate);
        }
        if ($this->type < 0 || $this->type > HolidayType::ALL) {
            throw new InvalidArgumentException('Type must be a combination of types as defined in the HolidayTypes class, got ' . $this->type);
        }
    }

    public static function create(string $name, string $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, $date, $type);
    }

    public static function createFromDateTime(string $name, DateTimeInterface $date, int $type = HolidayType::OTHER): self
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

    public function getDate(?DateTimeZone $dateTimeZone = null): DateTimeImmutable
    {
        // @phpstan-ignore-next-line
        return DateTimeImmutable::createFromFormat(static::CREATE_DATE_FORMAT, $this->simpleDate, $dateTimeZone);
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
