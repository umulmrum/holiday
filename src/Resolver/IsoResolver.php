<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Resolver;

use Umulmrum\Holiday\Provider\HolidayProviderInterface;

/**
 * IsoResolver resolves holiday providers that are given by their ISO-3166-1 ALPHA-2 or ISO-3166-2 code, see isoData.php
 * for the list of supported countries and regions.
 */
final class IsoResolver implements ProviderResolverInterface
{
    private static $MAP;

    /** @var bool */
    private $initialized;

    /**
     * {@inheritdoc}
     */
    public function resolveHolidayProvider(string $identifier): ?HolidayProviderInterface
    {
        $this->init();
        if (isset(self::$MAP[$identifier])) {
            return new self::$MAP[$identifier]();
        }

        return null;
    }

    /**
     * Initializes the resolver. This is done lazily to avoid having to instantiate the large array if it isn't used.
     */
    private function init(): void
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        self::$MAP = include __DIR__.'/isoData.php';
    }
}
