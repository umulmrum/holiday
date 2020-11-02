<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Translator;

use Umulmrum\Holiday\Model\Holiday;

final class NullTranslator implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday, string $locale = null): string
    {
        return $holiday->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $string, string $locale = null): string
    {
        return $string;
    }
}
