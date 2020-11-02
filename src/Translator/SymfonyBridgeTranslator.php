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

use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;
use Umulmrum\Holiday\Model\Holiday;

final class SymfonyBridgeTranslator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslatorInterface
     */
    private $translator;

    public function __construct(SymfonyTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday, string $locale = null): string
    {
        return $this->translator->trans($holiday->getName(), [], 'umulmrum_holiday', $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $string, string $locale = null): string
    {
        return $this->translator->trans($string, [], 'umulmrum_holiday', $locale);
    }
}
