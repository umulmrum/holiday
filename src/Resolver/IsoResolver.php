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
 * for the list of supported countries and regions. If an ISO-3166-2 region (code with a dash) that is not implemented
 * is given, a fallback to the ISO-3166 country is performed. There can be different reasons for the fallback and you
 * should check if this behaviour is correct for your use case:
 * - The region's holidays do not differ from the country.
 * - The region's holidays are not yet implemented.
 * - The given code is invalid but the part before the dash is valid.
 */
final class IsoResolver implements ProviderResolverInterface
{
    private const MAX_CODE_LENGTH = 7;

    private static $MAP;

    /** @var bool */
    private $initialized;

    /**
     * {@inheritdoc}
     */
    public function resolveHolidayProvider(string $identifier): ?HolidayProviderInterface
    {
        if (\strlen($identifier) > self::MAX_CODE_LENGTH) {
            return null;
        }
        $this->init();
        if (isset(self::$MAP[$identifier])) {
            return new self::$MAP[$identifier]();
        }

        if (\preg_match('#^([A-Z]{2})-#', $identifier, $matches)) {
            return $this->resolveHolidayProvider($matches[1]);
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
