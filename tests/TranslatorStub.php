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
    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday, string $locale = null): string
    {
        return $this->translate($holiday->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $string, string $locale = null): string
    {
        switch ($string) {
            case 'name': return 'Very name';
            case 'day_off': return 'Day off';
            case 'religious': return 'Religious';
            default: return $string;
        }
    }

    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        switch ($id) {
            case 'name': return 'Such name';
            case 'foo': return 'Bar';
            default: return $id;
        }
    }
}
