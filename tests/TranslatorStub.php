<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Test;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Translator\TranslatorInterface;

final class TranslatorStub implements TranslatorInterface, \Symfony\Contracts\Translation\TranslatorInterface
{
    public function translateName(Holiday $holiday, ?string $locale = null): string
    {
        return $this->translate($holiday->getName());
    }

    public function translate(string $string, ?string $locale = null): string
    {
        return match ($string) {
            'name' => 'Very name',
            'day_off' => 'Day off',
            'religious' => 'Religious',
            default => $string,
        };
    }

    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        return match ($id) {
            'name' => 'Such name',
            'foo' => 'Bar',
            default => $id,
        };
    }

    public function getLocale(): string
    {
        return 'en_US';
    }
}
