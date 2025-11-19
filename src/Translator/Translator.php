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

use function array_merge;
use function mb_substr;
use function strpos;

final class Translator implements TranslatorInterface
{
    /** @var array<array<string, string>> */
    private array $translations = [];
    private string $fallbackLocale;

    public function __construct(string $fallbackLocale = 'en', bool $addLibraryTranslations = true)
    {
        $this->fallbackLocale = $fallbackLocale;
        if ($addLibraryTranslations) {
            $this->addLibraryTranslations();
        }
    }

    private function addLibraryTranslations(): void
    {
        $this->addTranslations('en', include __DIR__ . '/../../res/trans/umulmrum_holiday.en.php');
        $this->addTranslations('de', include __DIR__ . '/../../res/trans/umulmrum_holiday.de.php');
        $this->addTranslations('pl', include __DIR__ . '/../../res/trans/umulmrum_holiday.pl.php');
    }

    /**
     * @param array<string, string> $translations
     */
    public function addTranslations(string $locale, array $translations): void
    {
        $this->translations[$locale] = array_merge($this->translations[$locale] ?? [], $translations);
    }

    public function translateName(Holiday $holiday, ?string $locale = null): string
    {
        return $this->translate($holiday->getName(), $locale);
    }

    public function translate(string $string, ?string $locale = null): string
    {
        if ($locale === null) {
            $locale = $this->fallbackLocale;
        }

        return $this->translations[$locale][$string]
            ?? $this->translations[$this->getBaseLanguage($locale)][$string]
            ?? $this->translations[$this->fallbackLocale][$string]
            ?? '';
    }

    private function getBaseLanguage(string $locale): string
    {
        if (false === $pos = strpos($locale, '_')) {
            return $locale;
        }

        return mb_substr($locale, 0, $pos);
    }
}
