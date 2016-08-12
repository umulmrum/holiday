
Holiday
=======

Holiday is a library that computes holidays in a very flexible way. It is possible to filter holiday lists by various
criteria and format them in different ways. It is easy to add more holiday providers, filters and formatters, so even
if this library does not perfectly fit your needs, you can simply extend it.

Requirements
------------

- PHP >= 5.4
- Symfony translator in any version

That's it really.

Installation
------------

Install the library using Composer.

```
composer require umulmrum/holiday
```

Usage
-----

Example:

```php
<?php

require 'vendor/autoload.php';

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Formatter\DateFormatter;
use umulmrum\Holiday\Provider\Germany\GermanyHolidayInitializer;
use umulmrum\Holiday\Provider\Germany\Bavaria;

// Get a HolidayCalculator object and initalize it with holiday providers.
$holidayCalculator = new HolidayCalculator(new GermanyHolidayInitializer());
// Calculate the holiday for one year in a region.
$holidays = $holidayCalculator->calculateHolidaysForYear(2016, Bavaria::ID);
// Optionally apply filters, e.g. restrict to one month
$holidays = (new IncludeTimespanFilter())->filter($holidays, [
        IncludeTimespanFilter::PARAM_FIRST_DAY => new DateTime('2016-12-01'),
        IncludeTimespanFilter::PARAM_LAST_DAY => new DateTime('2016-12-31'),
    ]);
// Optionally format the results
$formattedHolidays = (new DateFormatter())->formatList($holidays);

```

This results in an array of date strings that can be echoed or computed further.

There is also a `HolidayHelper` class that simplifies some common holiday
computations. This example can be substituted by this:

```php
<?php

require 'vendor/autoload.php';

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Formatter\DateFormatter;
use umulmrum\Holiday\Helper\HolidayHelper;
use umulmrum\Holiday\Provider\Germany\Bavaria;
use umulmrum\Holiday\Provider\Germany\GermanyHolidayInitializer;

// Get a HolidayCalculator object and initalize it with holiday providers.
$holidayCalculator = new HolidayCalculator(new GermanyHolidayInitializer());
// Get a HolidayHelper object and initalize it with the HolidayCalculator.
$holidayHelper = new HolidayHelper($holidayCalculator);
$holidays = $holidayHelper->getHolidaysForMonth(2016, 12, Bavaria::ID);
// Optionally format the results
$formattedHolidays = (new DateFormatter())->formatList($holidays);

```

The usage normally follows this pattern:

- compute all holidays for a given year and a holiday provider (e.g. a region)
- narrow down the list of holidays to the desired subset by using filters.
  The filters can be chained, so that for example all religious holidays
  in a certain month can be determined by chaining a type filter and a
  timespan filter.
  A few filters are provided in this library, more can be added freely.
- format the result using a formatter.
  A few formatters are provided in this library, more can be added freely.

Filters
-------

Filters can be used to narrow down or transform holiday lists. There are
some predefined filters, but custom ones can be created by implementing
the `HolidayFilterInterface`.
When implementing custom filters, it is suggested that you use a prefix
"Include" in the class name for all filters that preserve some holidays,
e.g. the `IncludeWeekdayFilter` preserves all holidays on a specific weekday.
Equally the prefix "Exclude" should be used for all filters that remove
some holidays.

Formatters
----------

Formatters can be used to format holidays and holiday lists. There are
some predefined formatters, but custom ones can be created by implementing
the `HolidayFormatterInterface`.

Translations
------------

Some formatters can be initialized with an optional translator. See the
`TranslatorInterface` and the translation files under `res/trans`.
  
Supported Countries
-------------------

Currently only Germany is supported, but you can easily create your own holiday providers. Just have a look at the
existing code, it should be self-explanatory. I will happily merge pull requests (see below).


Notices on German Holidays
--------------------------

- Easter Sunday/Ostersonntag and Whit Sunday/Pfingstsonntag are not public holidays in most states.
- Every sunday is a public holiday in Hesse.
- Assumption/Mariä Himmelfahrt is a public holiday in about 1700 of about 2000 communities in Bavaria. This is implemented
  as a partial holiday, so you might want to add your logic that filters this date.
- In Bavaria schools are closed on Assumption Day and on Repentance and Prayer Day. There is no special handling of
  this "behavior".
- Corpus Christi/Fronleichnam is a public holiday in some communities in Saxony and Thuringia.
- Regional holidays with traditionally (but not publicly) limited opening hours are not considered yet (e.g. carnival days).
- Some ports at the German Ocean celebrate some holidays as "High Holidays". It is generally not allowed to work on these days,
and work time ends at 12 o'clock the day before. This is not considered yet.
- Also there are some quiet days that are not public holidays in various states. This is also not considered yet.

Notice on Holidays Way in the Past or Future
--------------------------------------------

If computing holidays for past years, be aware that they may not be accurate.
All holidays were introduced at some point, so this lib might return holidays
for years in which they really weren't in existence, as well as omit holidays
that haven't been celebrated for a long time.

Likewise holidays might of course change in the future, so there is no
point in calculating them for the year 5000 (but if you ever wondered:
Easter Sunday will be on March 30, 5000).

Contribution
------------

Contributions are highly welcome. Please follow these rules when submitting a PR:

- mimic existing code for style and structure
- add unit tests for all of your code
- use the Symfony code style (php-cs-fixer with symfony level)

By submitting a PR you agree that all your contributed code may be used under the MIT license.

License
-------

Holiday is licensed under the MIT License. See [LICENSE](LICENSE) for details.

In short, this license allows you to use this code for almost anything you like. If you somehow make use of it to
suppress, injure, kill, spy, or any other thing considered evil, there is nothing in this license that holds you back. 
But fuck you anyway.

For all other people I hope this little lib helps you and perhaps even gives you some pleasure.
