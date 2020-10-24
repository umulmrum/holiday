<?php

namespace umulmrum\Holiday;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Translator\TranslatorInterface;

final class TranslatorStub implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday): string
    {
        return $this->translate($holiday->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $string): string
    {
        switch ($string) {
            case 'name': return 'Very name';
            case 'day_off': return 'Day off';
            case 'religious': return 'Religious';
            default: return '';
        }
    }
}
