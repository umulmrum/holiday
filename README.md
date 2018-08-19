
Holiday
=======

Holiday is a library that computes holidays in a very flexible way. It is possible to filter holiday lists by various
criteria and format them in different ways. It is easy to add more holiday providers, filters and formatters, so even
if this library does not perfectly fit your needs, you can simply extend it.

[![Latest Stable Version](https://poser.pugx.org/umulmrum/holiday/v/stable)](https://packagist.org/packages/umulmrum/holiday) [![Latest Unstable Version](https://poser.pugx.org/umulmrum/holiday/v/unstable)](https://packagist.org/packages/umulmrum/holiday) [![License](https://poser.pugx.org/umulmrum/holiday/license)](https://packagist.org/packages/umulmrum/holiday)

Requirements
------------

- PHP >= 7.1

- Symfony translator in any version is recommended for translations.

That's it really.

Installation
------------

Install the library using Composer.

```
composer require umulmrum/holiday
```

Usage
-----

Simple example:

```php
<?php

require 'vendor/autoload.php';

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Provider\Germany\Bavaria;

$holidayCalculator = new HolidayCalculator();
$holidays = $holidayCalculator->calculateHolidaysForYear(Bavaria::class, 2016);
```

This results in a `HolidayList` which contains all holidays for 2016; this list can then be used for output or further
computation. Holidays are always computed for one full year and can be narrowed down afterwards using filters.

More complex example:

```php
<?php

require 'vendor/autoload.php';

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Filter\IncludeTimespanFilter;
use umulmrum\Holiday\Formatter\DateFormatter;
use umulmrum\Holiday\Provider\Germany\Bavaria;

$holidayCalculator = new HolidayCalculator();
$holidays = $holidayCalculator->calculateHolidaysForYear(Bavaria::class, 2016);
// Apply filters, e.g. restrict to one month.
$firstDay = new \DateTime('2016-12-01');
$lastDay = new \DateTime('2016-12-31');
$holidays = (new IncludeTimespanFilter($firstDay, $lastDay))->filter($holidays);
// Format the results.
$formattedHolidays = (new DateFormatter())->formatList($holidays);
```

This results in an array of date strings.

There is also a `HolidayHelper` class that simplifies some common holiday computations. Using the helper, this example 
can be substituted by this:

```php
<?php

require 'vendor/autoload.php';

use umulmrum\Holiday\Calculator\HolidayCalculator;
use umulmrum\Holiday\Formatter\DateFormatter;
use umulmrum\Holiday\Helper\HolidayHelper;
use umulmrum\Holiday\Provider\Germany\Bavaria;

$holidayHelper = new HolidayHelper(new HolidayCalculator());
$holidays = $holidayHelper->getHolidaysForMonth(Bavaria::class, 2016, 12);
$formattedHolidays = (new DateFormatter())->formatList($holidays);
```

Usage normally follows this pattern:

- Compute all holidays for a given year and one or more holiday providers.
- Narrow down the list of holidays to the desired subset by using filters.
  Filters take `HolidayList`s and return `HolidayList`s and can therefore easily be chained (e.g. all religious holidays
  in a certain month can be determined by chaining a type filter and a time span filter).
  A few filters are provided in this library, more can be added freely.
- Format the result using a formatter.
  A few formatters are provided in this library, more can be added freely.

Holiday Types
-------------

Each holiday returned by the calculator has one or more types, returned by `Holiday::getType()`. The return value is a
bit map containing all applicable types (the type identifier can be converted to a translation key which can be 
translated to get a localized readable name - see e.g. `JsonFormatter` for details).

The type is normally a combination of
- the holiday's origin, e.g. religious or traditional,
- the holiday's legal status (official or not),
- the holiday's impact on working hours (e.g. if it's a full or half day off).

Which Holidays are Returned
---------------------------

The `HolidayCalculator` only returns holidays that are legally defined in the scope of the chosen holiday provider, or
if there's "secular impact", e.g. it's a day off. This means there are differences between providers; e.g. Easter Sunday
is an official holiday in Brandenburg/Germany, so it is included for Brandenburg. In the rest of Germany (as well as 
most other countries) it is not a holiday as it is a Sunday anyway, and therefore not included as a holiday.

Similarly, Sundays are normally not included if they are no official holidays in the scope of the holiday provider,
although they are days off in the Western hemisphere. To find out which days are days off, provide both the respective
holiday provider and the one for Sundays (or use `HolidayHelper::getNoWorkDaysForTimeSpan()`).

Filters
-------

Filters can be used to narrow down or transform holiday lists. There are some predefined filters (see `src/Filter`),
but custom ones can be created by implementing `HolidayFilterInterface`.

When implementing custom filters, it is suggested that you use a prefix "Include" in the class name for all filters that
preserve some holidays, e.g. the `IncludeWeekdayFilter` preserves all holidays on a specific weekday. Equally the prefix
"Exclude" should be used for all filters that remove some holidays.

Formatters
----------

Formatters can be used to format holidays and holiday lists. There are some predefined formatters (see `src/Formatter`),
but custom ones can be created by implementing `HolidayFormatterInterface`.

Translations
------------

Some formatters can be initialized with an optional translator. See `TranslatorInterface` and the translation files 
under `res/trans`.
 
Supported Calendars
-------------------

Currently only the Gregorian calendar is supported, for years < 10000.
 
Supported Countries
-------------------

- Austria
- Germany
- Liechtenstein
- Switzerland

It is quite easy to create your own holiday providers. Just have a look at the existing code, it should be 
self-explanatory. I will happily merge pull requests (see below).

Notes on German Holidays
------------------------

- Easter Sunday/Ostersonntag and Whit Sunday/Pfingstsonntag are not public holidays in most states.
- Every sunday is a public holiday in Hesse.
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

Notes on Swiss Holidays
-----------------------

- Holidays in Switzerland are really complicated as they differ widely in the different cantons and some holidays are
  celebrated inofficially or only in parts of a canton. The implemented rules are a best guess of what makes sense in
  the scope of this library (which also means that some holidays are omitted if they are a celebrated only in very few
  communities). I'm open for improvement suggestions.

Notes on Christian Holidays
---------------------------

- Only holidays of Western churches are taken into account.
- Only the most important holidays are taken into account, as interpreted by me (which is most likely far from accurate; 
  please feel free to contribute changes).

Note on Holidays Way in the Past or Future
------------------------------------------

If computing holidays for past years, be aware that they may not be accurate. All holidays were introduced at some 
point, so this lib might return holidays for years in which they really were not in existence, as well as omit holidays
that haven't been celebrated for a long time. This lib aims to be accurate for "recent" years at least, approximately 
for years after World War II.

Likewise holidays might of course change in the future. Also, Easter date calculation will change in the far future due 
to astronomical reasons. So there is no point in calculating holidays for the year 5000 (but in case you wondered: 
Easter Sunday will be on March 30, 5000).

Versioning
----------

This library follows Semantic Versioning. Everything in the library can be considered the public API except
 - code marked with `@internal`,
 - tests,
 - code that can only be accessed by using reflection (e.g. private methods). 

 Note that the library is still in a 0.* version which allows the public API to change anytime.

Contribution
------------

Contributions are highly welcome. Please follow these rules when submitting a PR:

- Mimic existing code for style and structure.
- Add unit tests for all of your code.
- Use the Symfony code style (php-cs-fixer with symfony level).

By submitting a PR you agree that all your contributed code may be used under the MIT license.

License
-------

Holiday is licensed under the MIT License. See [LICENSE](LICENSE) for details.

In short, this license allows you to use this code for almost anything you like. If you somehow make use of it to
suppress, injure, kill, spy, or any other thing considered evil, there is nothing in this license that holds you back. 
But fuck you anyway.

For all other people I hope this little lib helps you and perhaps even gives you some pleasure.
