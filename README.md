# Holiday

Holiday is a library that computes holidays in a very flexible way. It is possible to filter holiday lists by various
criteria and format them in different ways. It is easy to add more holiday providers, filters and formatters, so even
if this library does not perfectly fit your needs, you can simply extend it.

[![Latest Stable Version](https://poser.pugx.org/umulmrum/holiday/v/stable)](https://packagist.org/packages/umulmrum/holiday) [![Latest Unstable Version](https://poser.pugx.org/umulmrum/holiday/v/unstable)](https://packagist.org/packages/umulmrum/holiday) [![License](https://poser.pugx.org/umulmrum/holiday/license)](https://packagist.org/packages/umulmrum/holiday)

## Requirements

- PHP >= 8.2

That's it really.

## Installation

Install the library using Composer.

```
composer require umulmrum/holiday
```

## Usage Examples

Simple example:

```php
<?php

require 'vendor/autoload.php';

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Germany\Bavaria;

$holidayCalculator = new HolidayCalculator();
$holidays = $holidayCalculator->calculate(Bavaria::class, 2020);
```

This results in a `HolidayList` which contains all holidays for 2020; this list can then be used for output or further
computation. Holidays are always computed for one full year and can then be narrowed down using filters.

More complex example:

```php
<?php

require 'vendor/autoload.php';

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Filter\IncludeTimespanFilter;
use Umulmrum\Holiday\Formatter\DateFormatter;

$holidayCalculator = new HolidayCalculator();
$holidays = $holidayCalculator->calculate('DE-BY', 2020);
// Apply filters, e.g. restrict to one month.
$firstDay = new \DateTime('2020-12-01');
$lastDay = new \DateTime('2020-12-31');
$holidays = $holidays->filter(new IncludeTimespanFilter($firstDay, $lastDay));
// Format the results.
$formattedHolidays = $holidays->format(new DateFormatter());
```

This results in an array of date strings. Note that we used the ISO-3166-2 code `DE-BY` to get the holidays for Bavaria.
See section `Resolving Holiday Providers` below for different ways to request holidays.

There are also some helper methods that simplify some common holiday computations. Using the `GetHolidayForMonth` helper,
the example above can be substituted by this:

```php
<?php

require 'vendor/autoload.php';

use Umulmrum\Holiday\Formatter\DateFormatter;
use Umulmrum\Holiday\Helper\GetHolidaysForMonth;
use Umulmrum\Holiday\Provider\Germany\Bavaria;

$formattedHolidays = (new GetHolidaysForMonth())(Bavaria::class, 2020, 12)->format(new DateFormatter());
```

One last example shows how to compute all holidays, Saturdays and Sundays in the years 2020 and 2021 for the German state
Baden-Wuerttemberg, sort these holidays by date and format the result as JSON (all in 2 lines of code):

```php
<?php

require 'vendor/autoload.php';

use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Filter\SortByDateFilter;
use Umulmrum\Holiday\Formatter\JsonFormatter;
use Umulmrum\Holiday\Provider\Germany\BadenWuerttemberg;
use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Provider\Weekday\Sundays;

$calculator = new HolidayCalculator();
$holidays = $calculator->calculate([BadenWuerttemberg::class, Saturdays::class, Sundays::class], [2020, 2021]);
$formattedHolidays = $holidays->filter(new SortByDateFilter())->format(new JsonFormatter());
```

## Detailed Usage

First create a `HolidayList` for holidays in one or more years by using the `HolidayCalculator`. Pass one or more holiday
providers to the calculator to get holidays for these providers, e.g. a country, a religion or event a specific weekday.
`HolidayList` is basically an augmented array of `Holiday` objects.

```php
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Luxembourg\Luxembourg;
use Umulmrum\Holiday\Provider\Weekday\Saturdays;
use Umulmrum\Holiday\Provider\Weekday\Sundays;

$calculator = new HolidayCalculator();
$holidays = $calculator->calculate(Luxembourg::class, 2020);

// or multiple providers at once by passing an array of providers
$holidays = $calculator->calculate([Luxembourg::class, Saturdays::class, Sundays::class], 2020);

// or multiple years at once by passing an array of years (can be combined)
$holidays = $calculator->calculate(Luxembourg::class, [2020, 2021]);
```

See the complete list of built-in providers under `src/Provider` or use them as examples to create your own. Be aware that
a holiday is NOT equivalent to a day off - holidays in the sense of this lib is more of a "special day" as defined by
providers, and might be traditional or religious days without impact on working hours. To restrict a `HolidayList` to
days off, use the `IncludeTypeFilter` as described below in the `Filters` section.

The `HolidayList` can then be asked for information or holidays can be added or removed, the list can be filtered or formatted.

```php
// Get the number of holidays in the list. HolidayList also implements \Countable
$holidays->count();
```

```php
// Get the list of holidays as array. HolidayList also implements \IteratorAggregate
$holidays->getList();
$holidays->getIterator();
$holidays->getByName($holidayName)
```

```php
// Modify the list.
$holidays->add($anotherHoliday);
$holidays->addAll($anotherHolidayList);
$holidays->removeByName($holidayName);
$holidays->removeByIndex(3);
$holidays->replaceByNameAndDate($anotherHoliday);
$holidays->replaceByIndex(0, $anotherHoliday);
```

```php
// Check if a given date is in the list
$holidays->isHoliday(new \DateTime('2020-12-01'));
```

### Resolving Holiday Providers

The examples above already showed two different ways to specify for which region or other "entity" holidays should be
calculated. There are more ways, and complete customization is also possible - let's have a look at all of them:

1. Fully qualified class name:

    ```php
    $calculator->calculate(\Umulmrum\Holiday\Provider\France\France::class, 2020);
    ```
    
    This is suggested as default, since you only need to remember the region to request and IDEs should provide
    autocompletion to save keystrokes.

2. Instantiated class:

    ```php
    $calculator->calculate(new \Umulmrum\Holiday\Provider\Weekday\Sundays(\Umulmrum\Holiday\Constant\HolidayType::DAY_OFF), 2020);
    ```
    
    Use an instantiated class of the same type as you would specify when using way 1. Do this if a provider has constructor
    arguments, such as additional holiday types as seen in the example (Sundays aren't automatically days off).

3. ISO-3166 names:

    ```php
    $calculator->calculate('AT-9', 2020); // AT-9 = Vienna in Austria
    ```
    
    Use ISO-3166-1 country codes or ISO-3166-2 region codes e.g. if your application already uses them to simplify integration
    and decoupling of the Holiday lib. The list of supported countries and regions can be found in `src/Resolver/isoData.php`.
    There is a fallback to the base country in case the region code is not found - see the comment in the `IsoResolver`
    class for details.

4. Misc abbreviations:

    ```php
    $calculator->calculate('Christian', 2020);
    ```

    Additional short strings are defined in the `MiscResolver` class. Those are `Christian` for Christian holidays, as
    well as `Sun`, `Mon`, `Tue`, `Wed`, `Thu`, `Fri`, and `Sat` for the days of the week.

5. Custom

    ```php
    $calculator = new \Umulmrum\Holiday\HolidayCalculator(new \Umulmrum\Holiday\Resolver\ResolverHandler([new MyCustomResolver()]));
    ```
    
    Use this to add custom resolving logic. `ResolverHandler` takes an array of `ProviderResolverInterface`s (and implements
    `ResolverHandlerInterface`, so can even be exchanged with more custom code).

### Filters

Use filters to narrow down the list of holidays to the desired subset.

```php
use Umulmrum\Holiday\Constant\HolidayType;
use Umulmrum\Holiday\Filter\IncludeTimespanFilter;
use Umulmrum\Holiday\Filter\IncludeTypeFilter;

// Keep only work-free days (as defined in the provider(s) the list is derived from).
$holidays->filter(new IncludeTypeFilter(HolidayType::DAY_OFF));

/*
 * Filters modify the original list. The following example shows how to chain filters to get holidays with type DAY_OFF
 * in January 2020.
 */
$holidays
    ->filter(new IncludeTimespanFilter(new \DateTime('2020-01-01'), new \DateTime('2020-01-31')))
    ->filter(new IncludeTypeFilter(HolidayType::DAY_OFF))
;
```

See the complete list of built-in filters under `src/Filter` or use them as examples to create your own (extend
`AbstractFilter` or implement `HolidayFilterInterface`).

### Formatters

Use formatters to - you guessed it - format `HolidayList`s and `Holiday`s.

```php
use Umulmrum\Holiday\Formatter\JsonFormatter;

$formattedList = $holidayList->format(new JsonFormatter());
```

Formatters may return a string or an array of strings.

See the complete list of built-in formatters under `src/Formatter` or use them as examples to create your own (implement
`HolidayFormatterInterface`).

### Holiday Types

A `HolidayList` contains `Holiday` objects. Apart from a (technical) name and date, each holiday has one or more types.
Return these types as an integer bit mask by calling `Holiday::getType()`, or ask for specific types using
`Holiday::hasType()`.

The type is normally a combination of
- the holiday's origin, e.g. religious or traditional,
- the holiday's legal status (official or not),
- the holiday's impact on working hours (e.g. if it's a full or half day off, if schools or government agencies are closed).

See the `HolidayType` class for available types. This class also contains translation keys for these types
which can then get translated for localized readable names - see e.g. `JsonFormatter` for details.

### Which Holidays are Returned

`HolidayCalculator` only returns holidays that are legally defined in the scope of the chosen holiday provider, or
if there's "secular impact", e.g. it's a day off. This means there are differences between providers; e.g. Easter Sunday
is an official holiday in Brandenburg/Germany, so it is included for Brandenburg. In the rest of Germany (as well as 
most other countries) it is not a holiday as it is a Sunday anyway, and therefore not included as a holiday.

Similarly, Sundays are normally not included if they are no official holidays in the scope of the holiday provider,
although they are days off in the Western hemisphere. To find out which days are days off, provide both the respective
holiday provider and the one for Sundays (or use `GetNoWorkDaysForTimeSpan()`).

If your use case requires other holiday lists, consider combining multiple providers (e.g. `Switzerland` and
`ChristianHolidays`), or remove some using filters (e.g. combine `IncludeTypeFilter` and `InverseFilter`) to remove
Sundays from `Brandenburg` lists.

### Translations

Each holiday will be provided with a technical name that resembles the English name, e.g. `new_year`. To translate these
technical names into spoken languages, use the `Translator`. This class comes with English and German names for all
holidays, but other languages can be added (contributions welcome, but translation files can also be outside this
library).

The `TranslateFilter` can replace the names of all holidays in a `HolidayList` at once. Use it like this:

```php
use \Umulmrum\Holiday\Filter\TranslateFilter;

$holidayList->filter(new TranslateFilter(locale: 'en'));
```

The `TranslateFilter` uses the `Translator` with the built-in translations internally, but this can be customized - see
the constructors of the used classes.

Some formatters such as the `JsonFormatter` can also be initialized with an optional translator.

The `Translator` uses two levels of fallback for the passed locale:

- First, it tries to find the translation for the exact locale, e.g. `en_US`.
- If it isn't found, it tries the base language, e.g. `en`.
- If this is also not found, it tries the passed fallback language, which is configurable (default `en`).
- If this is also not found, it returns the empty string.

The translation files can be found under `res/trans`. They are written in PHP, compatible with the Symfony Translation
component, so they can be directly loaded using Symfony's `PhpFileLoader`.

There is also a `SymfonyBridgeTranslator` which enables usage of an existing Symfony translator (translation files need
to be registered separately).

### Helpers

To simplify some common holiday-related tasks, see the helpers under `src/Helper` (e.g. the `GetNoWorkDaysForTimeSpan`
helper takes holiday providers and a timespan and calculates a list of all days off for these arguments).
 
## Supported Calendars

Currently only the Gregorian calendar is supported, for years < 10000.
 
## Supported Countries

![World Map](/doc/world.svg)

(map created by simplemaps.com - licensed under MIT)

- Australia
- Austria (incl. Burgenland, Carinthia, Lower Austria, Salzburg, Styria, Tyrol, UpperAustria, Vienna, Vorarlberg)
- Belarus
- Belgium
- Brazil
- Bulgaria
- Canada
- Czech Republic
- Denmark
- Estonia
- Finland
- France (incl. Bas-Rhin, French Guiana, Guadeloupe, Haut-Rhin, Martinique, Moselle, Reunion)
- Germany (incl. Baden-Wuerttemberg, Bavaria, Berlin, Brandenburg, Bremen, Hamburg, Hesse, Lower Saxony, Mecklenburg-Vorpommern, North-rhine Westphalia, Rhineland Palatinate, Saarland, Saxony, Saxony-Anhalt, Schleswig-Holstein, Thuringia)
- Greenland
- Iceland
- Ireland
- Italy (incl. South Tyrol)
- Latvia
- Liechtenstein
- Lithuania
- Luxembourg
- Mexico
- The Netherlands
- Norway
- Poland
- Portugal (incl. Azores, Madeira, without municipal holidays)
- Russia
- Spain (common holidays only yet)
- Sweden
- Switzerland (incl. Aargau, Appenzell-Ausserrhoden, Appenzell-Innerrhoden, Basel Landschaft, Basel Stadt, Bern, Fribourg, Geneva, Glarus, Grisons, Jura, Lucerne, Neuchatel, Nidwalden, Obwalden, Schaffhausen, Schwyz, Solothurn, St Gallen, Thurgau, Ticino, Uri, Valais, Vaud, Zuerich, Zug)
- Turkey (without Islamic holidays yet)
- Ukraine
- United Kingdom (incl. England, Northern Ireland, Scotland (without local holidays), Wales; mainland only yet)
- USA (federal holidays only yet)

To create your own holiday providers have a look at the existing code, it should be self-explanatory. I will happily
merge pull requests to support more countries (see below).

### Notes on Canadian Holidays

- Holidays in Canada were hard to grasp while adding (for a non-Canadian). There are multiple levels of flexibility in
  the holidays (differences betweeen provinces/territories, role of government/private sector, negotiatability of
  substitue holidays). So the current state surely is not perfect and further proposals are highly welcome.

### Notes on German Holidays

- Easter Sunday/Ostersonntag and Whit Sunday/Pfingstsonntag are not public holidays in most states.
- Every Sunday is a public holiday in Hesse.
- Assumption/Mariä Himmelfahrt is a public holiday in about 1700 of about 2000 communities in Bavaria. This is 
  implemented as a partial holiday, so you might want to add your logic that filters this date.
- In Bavaria schools are closed on Assumption Day and on Repentance and Prayer Day. There is no special handling of
  this "behavior".
- Corpus Christi/Fronleichnam is a public holiday in some communities in Saxony and Thuringia.
- Regional holidays with traditionally (but not publicly) limited opening hours are not considered yet (e.g. carnival 
  days).
- Some ports at the German Ocean celebrate some holidays as "High Holidays". It is generally not allowed to work on 
  these days, and work time ends at 12 o'clock the day before. This is not considered yet.
- Also there are some quiet days that are not public holidays in various states. This is also not considered yet.
- New states of Germany are treated as if they had always been part of the Federal Republic of Germany. For years
  before 1990 holidays are therefore not correct.

### Notes on Swiss Holidays

- Holidays in Switzerland are really complicated as there is wide fragmentation on if or how holidays are celebrated.
  The implemented rules are a best guess of what makes sense in the scope of this library (written by someone who isn't
  from Switzerland). I'm open for improvements.

### Notes on Ukrainian Holidays

- Ukraine has been using the Revised Julian calendar in recent years. This calendar is not directly supported, but it is
  identical to the Gregorian calendar up to the year 2800.
- Years in which Easter falls on Sunday, May 1st (e.g. 2016) seem to be unclear regarding compensatory holidays. Treat
  those years with a grain of salt.

### Notes on Christian Holidays

- Only the most important holidays are taken into account, as interpreted by me (which is most likely far from accurate; 
  please feel free to contribute changes).

### Notes on Christian Orthodox Holiday

- Calculation of the Orthodox Easter date is only exact for the years 1900 through 2099.

### Note on Holidays Way in the Past or Future

If computing holidays for past years, be aware that they may not be accurate. All holidays were introduced at some 
point in time, so this lib might return holidays for years in which they really were not in existence, as well as omit
holidays that haven't been celebrated for a long time.
 
Likewise holidays might of course change in the future. Also, Easter date calculation will change in the far future due 
to astronomical reasons.

This lib aims to be accurate for "recent" years at least, approximately for years after World War II until present.
Again, contributions are welcome.

## Versioning

This library follows Semantic Versioning. Everything in the library can be considered the public API except:
 - code annotated with `@internal`,
 - tests,
 - code that can only be accessed by using reflection (e.g. private methods). 

 Note that the library is still in a 0.* version which allows the public API to change anytime.

## Contribution

Contributions are highly welcome. Please follow these rules when submitting a PR:

- Mimic existing code for style and structure.
- Add unit tests for all of your code; run the tests locally by calling `composer test`.
- Ideally, also run `composer analyze` and fix any reported errors.
- At the end, fix the code style by calling `composer cs` (you can omit this if you're in a hurry).

By submitting a PR you agree that all your contributed code may be used under the MIT license.

### Adding Tests 

    - Provide tests inside `tests/Provider/...` that ideally cover all edge cases. This can be done as follows:
  - First write the changes to the holiday provider itself
  - Then run a command that looks approximately like this: `tests/console test:generate DE-BY -y 2018 -y 2025`.
    Replace `DE-BY` with the ISO code of your new provider.
    Replace `-y 2018 -y 2025` with the years that make sense for your provider.
  - The test will calculate holidays for the selected years and generate markdown tables that are saved in the
    directory `tests/Provider/Data`. Find the file there and check if you are content with the result, but don't
    change the format of the file, as the test runner will expect it exactly like this.
  - If you need tests that can't be expressed like this (see e.g. Sweden), write those particular tests by hand.
  - **Windows: Please note** On windows the generator must be run in a bash window.


### How To Add a New Country or Region

- Add a provider for that country or region inside `src/Provider/...`.
- Should you need to add country-specific holiday names, add those to `Constant\HolidayName` and provide
  English translations inside `umulmrum_holiday.en.php`.
- Lookup the ISO code for your country or region and add it to `Resolver\isoData.php`. If you add a provider that does
  NOT add country data, please add it to the list in the `MiscResolver` class.
- If the country provides any form of substitute/compensatory holidays in case a holiday occurs on a weekend, proceed as
  follows:
  - Let the provider class implement `CompensatoryHolidayProviderInterface` instead of the default
    `HolidayProviderInterface`. Apart from that, add holidays without covering compensatory days at first.
  - Implement the method `getCompensatoryDaysCalculators` that should return an array of `CompensatoryDayCalculator`
    objects. These objects handle the compensatory days for the finished holiday list automatically. By default,
    compensatory days are calculated for all holidays, and assume the holidays are moved to Monday if they occur on
    Saturday or Sunday. This behavior can be adjusted by passing constructor arguments to `CompensatoryDayCalculator`.
    See e.g. the holiday providers for the United Kingdom or the USA for examples.
- Provide tests inside `tests/Provider/...` that ideally cover all edge cases. This can be done as follows:
  - First write the holiday provider itself
  - Then run a command that looks approximately like this: `tests/console test:generate DE-BY -y 2018 -y 2025`.
    Replace `DE-BY` with the ISO code of your new provider.
    Replace `-y 2018 -y 2025` with the years that make sense for your provider.
  - The test will calculate holidays for the selected years and generate markdown tables that are saved in the
    directory `tests/Provider/Data`. Find the file there and check if you are content with the result, but don't
    change the format of the file, as the test runner will expect it exactly like this.
  - If you need tests that can't be expressed like this (see e.g. Sweden), write those particular tests by hand.

## License

Holiday is licensed under the MIT License. See [LICENSE](LICENSE) for details.

In short, this license allows you to use this code for almost anything you like. If you somehow make use of it to
suppress, injure, kill, spy, or any other thing considered evil, there is nothing in this license that holds you back. 
But fuck you anyway.

For all other people I hope this little lib helps you and perhaps even gives you some pleasure.
