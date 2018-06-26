<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday;

use DateTimeZone;
use PHPUnit\Framework\TestCase;

class HolidayTestCase extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        date_default_timezone_set('UTC');
    }

    protected function getTimezone()
    {
        return new DateTimeZone('UTC');
    }
}
