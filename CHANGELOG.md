# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.6.0] - 2021-02-10

### Added
- Holidays for the Netherlands.

## [0.5.1] - 2020-12-08

### Changed
- Fixed lower-case namespace on `AbstractSortFilter` class.
- Added missing regions to world map.

## [0.5.0] - 2020-11-07

### Added
- Holidays for these countries: Brazil, Ireland, Mexico, Poland, Russia, Spain (by @marioquartz).
- Providers for countries or regions can now be referenced by their respective ISO-3166 code.
- Fat Tuesday in ChristianHolidays.
- SortByNameFilter and SortByTypeFilter.

### Changed
- Made provider resolving (from untyped arguments) more flexible by introducing provider resolvers.

## [0.4.0] - 2020-11-02

### Added
- Holidays for Italy.

### Changed
- Rename vendor namespace from umulmrum to Umulmrum to conform to common convention.
- Bavaria now derives from Germany instead of BadenWuerttemberg.

## [0.3.0] - 2020-11-01

There's a lot of API changes in this release - sorry for that, but I think the lib is way better and easier to use than before.
I hope this to be the only change this dramatic before release 1.0.0. There is no explicit migration guide, but if you
get stuck when upgrading, please open an issue and I will try to help.

### Added
- Holidays for these countries: Austria, Belgium, Denmark, France, Liechtenstein, Luxembourg, Switzerland, USA.
- Transaction scripts GetHolidaysByName, GetHolidaysForMonth and GetNoWorkDaysForTimeSpan to replace similarly named methods in HolidayHelper.
- Transaction script GetGracePeriod.
- Holiday::create() is a named constructor to simplify instantiation.
- Holiday::createFromDateTime() is a named constructor to simplify instantiation.
- Holiday::hasType() to check if the holiday has one or more passed types.
- Holiday::format() as an alternative to formatting holidays by calling HolidayFormatterInterface::format().
- HolidayList::isHoliday() as replacement for HolidayHelper::isDayAHoliday().
- HolidayList::filter() to simplify chaining of filters.
- HolidayList::format() as an alternative to formatting lists by calling HolidayFormatterInterface::formatList().
- AbstractFilter class to simplify filter implementations.
- FilterInverter to add inverse filters without almost-duplicate implementations.
- Add missing argument and return value declarations.

### Changed
- Bump minimum required PHP version to 7.3.0, minimum Symfony translator version to 4.3.0 (only if the optional SymfonyBridgeTranslator is used).
- Move HolidayCalculator and HolidayCalculatorInterface from namespace umulmrum\Holiday\Calculator to umulmrum\Holiday.
- Simplify API of HolidayCalculator: No longer require static initialization and identification of holiday providers.
  by an ID, but pass one or more providers directly. Also allow calculation of multiple years at once.
- Make dates in the Holiday class instances of DateTimeImmutable to have the class completely immutable.
- Let all dates in the lib use 00:00:00 as time part, as we only deal with whole days.
- No longer use timezones in holiday calculations and remove respective method arguments.
  Holidays only use a string-based date now internally, but can return a \DateTime object with time set to 00:00:00 in
  any timezone (current timezone by default).
- Let filters modify the original list instead of creating a new one.
- Remove options for filter calls. Options are now passed in the filter constructors (it's a bit less flexible but type-safe and easier to use).
- Rename DateHelper to DateProvider and add DateProviderInterface.
- Throw InvalidArgumentExceptions instead of HolidayExceptions.
- HolidayList is now traversable.
- Methods in TranslatorInterface can now receive an optional locale.

### Removed
- Remove HolidayInitializerInterface and all implementations, as they overcomplicated things and are no longer required.
- Remove IDs from holiday providers as they are now identified by fully qualified class name.
- Remove explicit filter chaining in filter classes. Do this by calling HolidayList::filter() now.
- Remove HolidayHelper class, as helper classes are an anti-pattern. Move functionality to other places as stated above.
- Remove HolidayException.
- Remove Holiday::getTimestamp(). Use Holiday::getDate()::getTimestamp() instead.
- Remove Holiday::getFormattedDate(). Use Holiday::getDate()::format() instead.

### Fixed

## [0.2.1] - 2018-09-05

(see linked diff)

## [0.2.0] - 2018-06-26

(see linked diff)

## [0.1.4] - 2018-06-26

(see linked diff)

## [0.1.3] - 2017-11-24

(see linked diff)

## [0.1.2] - 2016-09-18

(see linked diff)

## [0.1.1] - 2016-09-16

(see linked diff)

## [0.1.0] - 2016-09-16

(see linked diff)

[Unreleased]: https://github.com/umulmrum/holiday/compare/0.6.0...master
[0.6.0]: https://github.com/umulmrum/holiday/compare/0.5.1...0.6.0
[0.5.1]: https://github.com/umulmrum/holiday/compare/0.5.0...0.5.1
[0.5.0]: https://github.com/umulmrum/holiday/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/umulmrum/holiday/compare/0.3.0...0.4.0
[0.3.0]: https://github.com/umulmrum/holiday/compare/0.2.1...0.3.0
[0.2.1]: https://github.com/umulmrum/holiday/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/umulmrum/holiday/compare/0.1.4...0.2.0
[0.1.4]: https://github.com/umulmrum/holiday/compare/0.1.3...0.1.4
[0.1.3]: https://github.com/umulmrum/holiday/compare/0.1.2...0.1.3
[0.1.2]: https://github.com/umulmrum/holiday/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/umulmrum/holiday/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/umulmrum/holiday/releases/tag/0.1.0
