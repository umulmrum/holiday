<?php

namespace umulmrum\Holiday;

use umulmrum\Holiday\Helper\DateProviderInterface;

final class DateProviderStub implements DateProviderInterface
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getCurrentDate(): \DateTime
    {
        return $this->dateTime;
    }
}
