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

interface ProviderResolverInterface
{
    /**
     * Returns an object implementing HolidayProviderInterface for the given $identifer, or null if no provider can be
     * found.
     *
     * @throws \InvalidArgumentException if the identifier can be handled by the resolver but is invalid
     */
    public function resolveHolidayProvider(string $identifier): ?HolidayProviderInterface;
}
