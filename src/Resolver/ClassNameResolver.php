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

final class ClassNameResolver implements ProviderResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolveHolidayProvider(string $identifier): ?HolidayProviderInterface
    {
        if (false === \class_exists($identifier)) {
            return null;
        }

        $holidayProvider = new $identifier();
        if (false === $holidayProvider instanceof HolidayProviderInterface) {
            throw new \InvalidArgumentException(sprintf('Class does not implement HolidayProviderInterface: %s', $identifier));
        }

        return $holidayProvider;
    }
}
