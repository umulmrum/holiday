<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    /**
     * {@inheritdoc}
     */
    public function translate($string)
    {
        return $string;
    }
}
