<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umulmrum\Holiday\Constant;

/**
 * @codeCoverageIgnore
 */
final class HolidayName
{
    public const SUFFIX_COMPENSATORY = '_compensatory';

    // Common
    public const NEW_YEAR = 'new_year';
    public const NEW_YEAR_COMPENSATORY = self::NEW_YEAR.self::SUFFIX_COMPENSATORY;
    public const INTERNATIONAL_WOMENS_DAY = 'international_womens_day';
    public const LABOR_DAY = 'labor_day';
    public const NEW_YEARS_EVE = 'new_years_eve';
    public const VICTORY_IN_EUROPE_DAY = 'victory_in_europe_day';

    // Christian
    public const FAT_TUESDAY = 'fat_tuesday';
    public const ASH_WEDNESDAY = 'ash_wednesday';
    public const EPIPHANY = 'epiphany';
    public const CANDLEMAS = 'candlemas';
    public const SAINT_JOSEPHS_DAY = 'saint_josephs_day';
    public const MAUNDY_THURSDAY = 'maundy_thursday';
    public const GOOD_FRIDAY = 'good_friday';
    public const EASTER_SUNDAY = 'easter_sunday';
    public const EASTER_MONDAY = 'easter_monday';
    public const FEAST_OF_SAINTS_PETER_AND_PAUL = 'feast_of_saints_peter_and_paul';
    public const ASCENSION = 'ascension';
    public const WHIT_SUNDAY = 'whit_sunday';
    public const WHIT_MONDAY = 'whit_monday';
    public const CORPUS_CHRISTI = 'corpus_christi';
    public const SAINT_FLORIANS_DAY = 'saint_florians_day';
    public const SAINT_MAURICE_DAY = 'saint_maurice_day';
    public const ASSUMPTION_DAY = 'assumption_day';
    public const NATIVITY_OF_MARY = 'nativity_of_mary';
    public const REFORMATION_DAY = 'reformation_day';
    public const HALLOWEEN = 'halloween';
    public const ALL_SAINTS_DAY = 'all_saints_day';
    public const ALL_SOULS_DAY = 'all_souls_day';
    public const SAINT_MARTINS_DAY = 'saint_martins_day';
    public const SAINT_RUPERTS_DAY = 'saint_ruperts_day';
    public const LEOPOLDS_DAY = 'leopolds_day';
    public const REPENTANCE_AND_PRAYER_DAY = 'repentance_and_prayer_day';
    public const IMMACULATE_CONCEPTION = 'immaculate_conception';
    public const CHRISTMAS_EVE = 'christmas_eve';
    public const CHRISTMAS_DAY = 'christmas_day';
    public const CHRISTMAS_DAY_COMPENSATORY = self::CHRISTMAS_DAY.self::SUFFIX_COMPENSATORY;
    public const SECOND_CHRISTMAS_DAY = 'second_christmas_day';
    public const SECOND_CHRISTMAS_DAY_COMPENSATORY = self::SECOND_CHRISTMAS_DAY.self::SUFFIX_COMPENSATORY;
    public const VALENTINES_DAY = 'valentines_day';

    // Austria
    public const AUSTRIAN_NATIONAL_HOLIDAY = 'austrian_national_holiday';
    public const AUSTRIAN_STATES_HOLIDAY = 'austrian_states_holiday';
    public const CARINTHIAN_PLEBISCITE_DAY = 'carinthian_plebiscite_day';

    // Belgium
    public const ARMISTICE_DAY = 'armistice_day';
    public const BELGIAN_KINGS_FEAST = 'belgian_kings_feast';
    public const BELGIAN_NATIONAL_HOLIDAY = 'belgian_national_holiday';
    public const DAY_OF_THE_FLEMISH_COMMUNITY = 'day_of_the_flemish_community';
    public const DAY_OF_THE_GERMAN_SPEAKING_COMMUNITY = 'day_of_the_german_speaking_community';
    public const DAY_OF_THE_WALLOON_REGION = 'day_of_the_walloon_region';
    public const FRENCH_COMMUNITY_HOLIDAY = 'french_community_day';

    // Brazil
    public const DAY_OF_THE_DEAD = 'day_of_the_dead';
    public const ELECTORAL_DAY_ROUND_ONE = 'electoral_day_round_one';
    public const ELECTORAL_DAY_ROUND_TWO = 'electoral_day_round_two';
    public const OUR_LADY_OF_APARECIDA = 'our_lady_of_aparecida';
    public const REPUBLIC_PROCLAMATION_DAY = 'republic_proclamation_day';
    public const TIRADENTES = 'tiradentes';

    // Denmark
    public const DANISH_NATIONAL_HOLIDAY = 'danish_national_holiday';
    public const GENERAL_PRAYER_DAY = 'general_prayer_day';

    // France
    public const ABOLITION_OF_SLAVERY = 'abolition_of_slavery';
    public const ARMISTICE_DAY_FRANCE = 'armistice_day_france';
    public const BASTILLE_DAY = 'bastille_day';
    public const VICTORY_DAY = 'victory_day';

    // Germany
    public const AUGSBURGER_FRIEDENSFEST = 'augsburger_friedensfest';
    public const GERMAN_UNITY_DAY = 'german_unity_day';

    // Ireland
    public const AUGUST_HOLIDAY = 'august_holiday';
    public const MAY_DAY = 'may_day';
    public const JUNE_HOLIDAY = 'june_holiday';
    public const OCTOBER_HOLIDAY = 'october_holiday';
    public const SAINT_PATRICKS_DAY = 'saint_patricks_day';
    public const SAINT_PATRICKS_DAY_COMPENSATORY = self::SAINT_PATRICKS_DAY.self::SUFFIX_COMPENSATORY;

    // Italy
    public const ANNIVERSARY_OF_THE_UNIFICATION_OF_ITALY = 'anniversary_of_the_unification_of_italy';
    public const INTERNATIONAL_HOLOCAUST_REMEMBRANCE_DAY = 'international_holocaust_remembrance_day';
    public const LIBERATION_DAY = 'liberation_day';
    public const REPUBLIC_DAY = 'republic_day';
    public const TRICOLOUR_DAY = 'tricolour_day';

    // Luxembourg
    public const EUROPE_DAY = 'europe_day';
    public const GRAND_DUKES_OFFICIAL_BIRTHDAY = 'grand_dukes_official_birthday';

    // Mexico
    public const BIRTHDAY_OF_BENITO_JUAREZ = 'birthday_of_benito_juarez';
    public const REVOLUTION_DAY = 'revolution_day';

    // Netherlands
    public const DUTCH_LIBERATION_DAY = 'liberation_day';
    public const QUEENS_DAY = 'queens_day';
    public const KINGS_DAY = 'kings_day';

    // Poland
    public const CONSTITUTION_DAY = 'constitution_day';
    public const POLISH_ARMED_FORCES_DAY = 'polish_armed_forces_day';

    // Russia
    public const DECLARATION_OF_SOVEREIGNTY_DAY = 'declaration_of_sovereignty_day';
    public const DECLARATION_OF_SOVEREIGNTY_DAY_COMPENSATORY = 'declaration_of_sovereignty_day_compensatory';
    public const DEFENDER_OF_THE_FATHERLAND_DAY = 'defender_of_the_fatherland_day';
    public const DEFENDER_OF_THE_FATHERLAND_DAY_COMPENSATORY = 'defender_of_the_fatherland_day_compensatory';
    public const NEW_YEAR_HOLIDAY = 'new_year_holiday';
    public const OCTOBER_REVOLUTION_DAY = 'october_revolution_day';
    public const OCTOBER_REVOLUTION_DAY_COMPENSATORY = 'october_revolution_day_compensatory';
    public const RUSSIA_DAY = 'russia_day';
    public const RUSSIA_DAY_COMPENSATORY = 'russia_day_compensatory';
    public const SPRING_AND_LABOUR_DAY = 'spring_and_labour_day';
    public const SPRING_AND_LABOUR_DAY_COMPENSATORY = 'spring_and_labour_day_compensatory';
    public const UNITY_DAY = 'unity_day';
    public const UNITY_DAY_COMPENSATORY = 'unity_day_compensatory';

    // Spain
    public const SPANISH_NATIONAL_DAY = 'spanish_national_day';

    // Switzerland
    public const BERCHTOLDSTAG = 'berchtoldstag';
    public const BETTAGSMONTAG = 'bettagsmontag';
    public const FEST_DER_UNABHAENGIGKEIT_JURA = 'fest_der_unabhaengigkeit_jura';
    public const GENEVA_RESTORATION_OF_THE_REPUBLIC = 'geneva_restoration_of_the_republic';
    public const GENFER_BETTAG = 'genfer_bettag';
    public const JAHRESTAG_AUSRUFUNG_REPUBLIK_NEUENBURG = 'jahrestag_ausrufung_republik_neuenburg';
    public const NAEFELSER_FAHRT = 'naefelser_fahrt';
    public const SAINT_NICHOLAS_DAY = 'saint_nicholas_day';
    public const SWISS_NATIONAL_DAY = 'swiss_national_day';

    // USA
    public const COLUMBUS_DAY = 'columbus_day';
    public const INDEPENDENCE_DAY = 'independence_day';
    public const INDEPENDENCE_DAY_COMPENSATORY = self::INDEPENDENCE_DAY.self::SUFFIX_COMPENSATORY;
    public const MARTIN_LUTHER_KING_JR_DAY = 'martin_luther_king_jr_day';
    public const MEMORIAL_DAY = 'memorial_day';
    public const THANKSGIVING_DAY = 'thanksgiving_day';
    public const VETERANS_DAY = 'veterans_day';
    public const VETERANS_DAY_COMPENSATORY = self::VETERANS_DAY.self::SUFFIX_COMPENSATORY;
    public const WASHINGTONS_BIRTHDAY = 'washingtons_birthday';

    // Weekdays
    public const SUNDAY = 'sunday';
    public const MONDAY = 'monday';
    public const TUESDAY = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY = 'thursday';
    public const FRIDAY = 'friday';
    public const SATURDAY = 'saturday';
}
