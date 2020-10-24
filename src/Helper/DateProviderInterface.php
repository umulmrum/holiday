<?php

namespace umulmrum\Holiday\Helper;


/**
 * DateProviderInterface is a simple encapsulation for getting the current date.
 * Its purpose is only to be able to mock the date in unit tests.
 *
 * @codeCoverageIgnore
 */
interface DateProviderInterface
{
    public function getCurrentDate(): \DateTime;
}