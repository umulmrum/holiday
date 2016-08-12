<?php

namespace umulmrum\Holiday\Translator;

use umulmrum\Holiday\Model\Holiday;

interface TranslatorInterface
{
    /**
     * Translates the holiday name. How this translation is performed is completely up to the implementation.
     *
     * @param Holiday $holiday
     *
     * @return string
     */
    public function translateName(Holiday $holiday);
}
