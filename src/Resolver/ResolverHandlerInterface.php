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

use InvalidArgumentException;
use Umulmrum\Holiday\Provider\HolidayProviderInterface;

interface ResolverHandlerInterface
{
    /**
     * @param HolidayProviderInterface|HolidayProviderInterface[]|string|string[] $identifier
     *
     * @return HolidayProviderInterface[]
     *
     * @throws InvalidArgumentException
     */
    public function resolve($identifier): array;
}
