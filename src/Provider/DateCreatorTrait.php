<?php

namespace Umulmrum\Holiday\Provider;

use Umulmrum\Holiday\Model\Holiday;

trait DateCreatorTrait
{
    private function createDateFromString(string $dateString, ?\DateTimeZone $dateTimeZone = null): \DateTime
    {
        return \DateTime::createFromFormat(Holiday::CREATE_DATE_FORMAT, $dateString, $dateTimeZone); /** @phpstan-ignore-line */
    }

    private function createDisplayDateFromString(string $dateString, ?\DateTimeZone $dateTimeZone = null): \DateTime
    {
        return \DateTime::createFromFormat(Holiday::DISPLAY_DATE_FORMAT, $dateString, $dateTimeZone); /** @phpstan-ignore-line */
    }
}
