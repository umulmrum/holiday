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

use Umulmrum\Holiday\Provider\Religion\ChristianHolidays;
use Umulmrum\Holiday\Provider\Weekday\Fridays;
use Umulmrum\Holiday\Provider\Weekday\Mondays;
use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Provider\Weekday\Sundays;
use Umulmrum\Holiday\Provider\Weekday\Thursdays;
use Umulmrum\Holiday\Provider\Weekday\Tuesdays;
use Umulmrum\Holiday\Provider\Weekday\Wednesdays;

final class MiscResolver implements ProviderResolverInterface
{
    /** @var class-string[] */
    private static array $MAP = [
        'Christian' => ChristianHolidays::class,
        'Sun' => Sundays::class,
        'Mon' => Mondays::class,
        'Tue' => Tuesdays::class,
        'Wed' => Wednesdays::class,
        'Thu' => Thursdays::class,
        'Fri' => Fridays::class,
        'Sat' => Saturdays::class,
    ];

    public function resolveHolidayProvider(string $identifier): ?HolidayProviderInterface
    {
        if (isset(self::$MAP[$identifier])) {
            /** @var HolidayProviderInterface $provider */
            $provider = new self::$MAP[$identifier]();

            return $provider;
        }

        return null;
    }
}
