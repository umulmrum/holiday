<?php

namespace umulmrum\Holiday\Translator;

use umulmrum\Holiday\Model\Holiday;

class NullTranslator implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday)
    {
        return $holiday->getName();
    }
}
