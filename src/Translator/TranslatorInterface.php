<?php

namespace umulmrum\Holiday\Translator;

use umulmrum\Holiday\Model\Holiday;

interface TranslatorInterface
{
    /**
     * @param Holiday $holiday
     *
     * @return string
     */
    public function translateName(Holiday $holiday);
}
