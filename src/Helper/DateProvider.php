<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Helper;

/**
 * DateHelper is a simple encapsulation for getting the current date.
 * Its purpose is only to be able to mock the date in unit tests.
 *
 * @codeCoverageIgnore
 */
final class DateProvider implements DateProviderInterface
{
    public function getCurrentDate(): \DateTime
    {
        return new \DateTime('now');
    }
}
