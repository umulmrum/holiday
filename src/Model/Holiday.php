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

class Holiday
{
    public const DATE_FORMAT = '!Y-m-d';

    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeImmutable
     */
    private $date;
    /**
     * @var int
     */
    private $type;

    public function __construct(string $name, \DateTimeImmutable $date, int $type = HolidayType::OTHER)
    {
        $this->name = $name;
        $this->date = $date;
        $this->type = $type;
    }

    public static function create(string $name, string $date, int $type = HolidayType::OTHER): self
    {
        return new self($name, \DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $date), $type);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): \DateTimeImmutable
    {
        return clone $this->date;
    }

    public function getTimestamp(): int
    {
        return $this->date->getTimestamp();
    }

    public function getFormattedDate(string $format): string
    {
        return $this->date->format($format);
    }

    public function getType(): int
    {
        return $this->type;
    }
}
