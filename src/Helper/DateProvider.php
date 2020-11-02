<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Helper;

final class DateProvider implements DateProviderInterface
{
    public function getCurrentDate(): \DateTime
    {
        return new \DateTime('now');
    }
}
