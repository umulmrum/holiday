<?php


namespace umulmrum\Holiday;


use DateTimeZone;
use PHPUnit_Framework_TestCase;

class HolidayTestCase extends PHPUnit_Framework_TestCase
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