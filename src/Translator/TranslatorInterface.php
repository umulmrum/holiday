<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Translator;

use umulmrum\Holiday\Model\Holiday;

/**
 * @codeCoverageIgnore
 */
interface TranslatorInterface
{
    /**
     * Translates the holiday name. How this translation is performed is completely up to the implementation.
     *
     * @param Holiday $holiday
     *
     * @return string
     */
    public function translateName(Holiday $holiday): string;

    /**
     * Translates an arbitrary string.
     *
     * @param string $string
     *
     * @return string
     */
    public function translate(string $string): string;
}
