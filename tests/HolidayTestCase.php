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

use PHPUnit\Framework\TestCase;

class HolidayTestCase extends TestCase
{
    private $originalTimezone;

    protected function setUp()
    {
        parent::setUp();

        $this->originalTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    protected function tearDown()
    {
        parent::tearDown();
        date_default_timezone_set($this->originalTimezone);
    }

    protected function getTimezone(): \DateTimeZone
    {
        return new \DateTimeZone('UTC');
    }
}
