<?php

namespace umulmrum\Holiday\Model;

use DateTime;

class Holiday
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var DateTime
     */
    private $date;
    /**
     * @var int
     */
    private $type;

    /**
     * @param string   $name
     * @param DateTime $date
     * @param int      $type
     */
    public function __construct($name, DateTime $date, $type = 0)
    {
        $this->name = $name;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return clone $this->date;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->date->getTimestamp();
    }

    public function getFormattedDate($format)
    {
        return $this->date->format($format);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
