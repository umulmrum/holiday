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

use Umulmrum\Holiday\Resolver\ResolverHandlerInterface;

final class ResolverHandlerStub implements ResolverHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve($identifier): array
    {
        return [new HolidayProviderStub()];
    }
}
