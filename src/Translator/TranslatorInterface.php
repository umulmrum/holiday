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

/**
 * @codeCoverageIgnore
 */
interface TranslatorInterface
{
    /**
     * Translates the holiday name. How this translation is performed is completely up to the implementation.
     * If $locale is passed, translations should be in that locale, else it is up to the implementation to choose the
     * correct locale.
     */
    public function translateName(Holiday $holiday, string $locale = null): string;

    /**
     * Translates an arbitrary string.
     * If $locale is passed, translations should be in that locale, else it is up to the implementation to choose the
     * correct locale.
     */
    public function translate(string $string, string $locale = null): string;
}
