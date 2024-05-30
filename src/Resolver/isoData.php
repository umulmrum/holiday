<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * See https://www.iso.org/obp/ui/#search for country and region data
 */
return [
    // Austria
    'AT' => \Umulmrum\Holiday\Provider\Austria\Austria::class,
    'AT-1' => \Umulmrum\Holiday\Provider\Austria\Burgenland::class,
    'AT-2' => \Umulmrum\Holiday\Provider\Austria\Carinthia::class,
    'AT-3' => \Umulmrum\Holiday\Provider\Austria\LowerAustria::class,
    'AT-4' => \Umulmrum\Holiday\Provider\Austria\UpperAustria::class,
    'AT-5' => \Umulmrum\Holiday\Provider\Austria\Salzburg::class,
    'AT-6' => \Umulmrum\Holiday\Provider\Austria\Styria::class,
    'AT-7' => \Umulmrum\Holiday\Provider\Austria\Tyrol::class,
    'AT-8' => \Umulmrum\Holiday\Provider\Austria\Vorarlberg::class,
    'AT-9' => \Umulmrum\Holiday\Provider\Austria\Vienna::class,

    // Belgium
    'BE' => \Umulmrum\Holiday\Provider\Belgium\Belgium::class,

    // Brazil
    'BR' => \Umulmrum\Holiday\Provider\Brazil\Brazil::class,

    // Canada
    'CA' => \Umulmrum\Holiday\Provider\Canada\Canada::class,
    'CA-AB' => \Umulmrum\Holiday\Provider\Canada\Alberta::class,
    'CA-BC' => \Umulmrum\Holiday\Provider\Canada\BritishColumbia::class,
    'CA-MB' => \Umulmrum\Holiday\Provider\Canada\Manitoba::class,
    'CA-NB' => \Umulmrum\Holiday\Provider\Canada\NewBrunswick::class,
    'CA-NL' => \Umulmrum\Holiday\Provider\Canada\NewFoundlandAndLabrador::class,
    'CA-NT' => \Umulmrum\Holiday\Provider\Canada\NorthwestTerritories::class,
    'CA-NS' => \Umulmrum\Holiday\Provider\Canada\NovaScotia::class,
    'CA-NU' => \Umulmrum\Holiday\Provider\Canada\Nunavut::class,
    'CA-ON' => \Umulmrum\Holiday\Provider\Canada\Ontario::class,
    'CA-PE' => \Umulmrum\Holiday\Provider\Canada\PrinceEdwardIsland::class,
    'CA-QC' => \Umulmrum\Holiday\Provider\Canada\Quebec::class,
    'CA-SK' => \Umulmrum\Holiday\Provider\Canada\Saskatchewan::class,
    'CA-YT' => \Umulmrum\Holiday\Provider\Canada\Yukon::class,

    // Denmark
    'DK' => \Umulmrum\Holiday\Provider\Denmark\Denmark::class,

    // Finland
    'FI' => \Umulmrum\Holiday\Provider\Finland\Finland::class,

    // France
    'FR' => \Umulmrum\Holiday\Provider\France\France::class,
    'FR-57' => \Umulmrum\Holiday\Provider\France\Moselle::class,
    'FR-67' => \Umulmrum\Holiday\Provider\France\BasRhin::class,
    'FR-68' => \Umulmrum\Holiday\Provider\France\HautRhin::class,
    'FR-GF' => \Umulmrum\Holiday\Provider\France\FrenchGuiana::class,
    'FR-GUA' => \Umulmrum\Holiday\Provider\France\Guadeloupe::class,
    'FR-LRE' => \Umulmrum\Holiday\Provider\France\Reunion::class,
    'FR-MQ' => \Umulmrum\Holiday\Provider\France\Martinique::class,

    // Germany
    'DE' => \Umulmrum\Holiday\Provider\Germany\Germany::class,
    'DE-BB' => \Umulmrum\Holiday\Provider\Germany\Brandenburg::class,
    'DE-BE' => \Umulmrum\Holiday\Provider\Germany\Berlin::class,
    'DE-BW' => \Umulmrum\Holiday\Provider\Germany\BadenWuerttemberg::class,
    'DE-BY' => \Umulmrum\Holiday\Provider\Germany\Bavaria::class,
    'DE-HB' => \Umulmrum\Holiday\Provider\Germany\Bremen::class,
    'DE-HE' => \Umulmrum\Holiday\Provider\Germany\Hesse::class,
    'DE-HH' => \Umulmrum\Holiday\Provider\Germany\Hamburg::class,
    'DE-MV' => \Umulmrum\Holiday\Provider\Germany\MecklenburgVorpommern::class,
    'DE-NI' => \Umulmrum\Holiday\Provider\Germany\LowerSaxony::class,
    'DE-NW' => \Umulmrum\Holiday\Provider\Germany\NorthRhineWestphalia::class,
    'DE-RP' => \Umulmrum\Holiday\Provider\Germany\RhinelandPalatinate::class,
    'DE-SH' => \Umulmrum\Holiday\Provider\Germany\SchleswigHolstein::class,
    'DE-SL' => \Umulmrum\Holiday\Provider\Germany\Saarland::class,
    'DE-SN' => \Umulmrum\Holiday\Provider\Germany\Saxony::class,
    'DE-ST' => \Umulmrum\Holiday\Provider\Germany\SaxonyAnhalt::class,
    'DE-TH' => \Umulmrum\Holiday\Provider\Germany\Thuringia::class,

    // Greenland
    'GL' => \Umulmrum\Holiday\Provider\Greenland\Greenland::class,

    // Iceland
    'IS' => \Umulmrum\Holiday\Provider\Iceland\Iceland::class,

    // Ireland
    'IE' => \Umulmrum\Holiday\Provider\Ireland\Ireland::class,

    // Italy
    'IT' => \Umulmrum\Holiday\Provider\Italy\Italy::class,
    'IT-32' => \Umulmrum\Holiday\Provider\Italy\SouthTyrol::class,

    // Liechtenstein
    'FL' => \Umulmrum\Holiday\Provider\Liechtenstein\Liechtenstein::class,

    // Luxembourg
    'LU' => \Umulmrum\Holiday\Provider\Luxembourg\Luxembourg::class,

    // Mexico
    'MX' => \Umulmrum\Holiday\Provider\Mexico\Mexico::class,

    // Netherlands
    'NL' => \Umulmrum\Holiday\Provider\Netherlands\Netherlands::class,

    // Norway
    'NO' => \Umulmrum\Holiday\Provider\Norway\Norway::class,

    // Poland
    'PL' => \Umulmrum\Holiday\Provider\Poland\Poland::class,

    // Portugal
    'PT' => \Umulmrum\Holiday\Provider\Portugal\Portugal::class,
    'PT-20' => \Umulmrum\Holiday\Provider\Portugal\Azores::class,
    'PT-30' => \Umulmrum\Holiday\Provider\Portugal\Madeira::class,

    // Russia
    'RU' => \Umulmrum\Holiday\Provider\Russia\Russia::class,

    // Spain
    'ES' => \Umulmrum\Holiday\Provider\Spain\Spain::class,

    // Sweden
    'SE' => \Umulmrum\Holiday\Provider\Sweden\Sweden::class,

    // Switzerland
    'CH' => \Umulmrum\Holiday\Provider\Switzerland\Switzerland::class,
    'CH-AG' => \Umulmrum\Holiday\Provider\Switzerland\Aargau::class,
    'CH-AI' => \Umulmrum\Holiday\Provider\Switzerland\AppenzellInnerrhoden::class,
    'CH-AR' => \Umulmrum\Holiday\Provider\Switzerland\AppenzellAusserrhoden::class,
    'CH-BE' => \Umulmrum\Holiday\Provider\Switzerland\Bern::class,
    'CH-BL' => \Umulmrum\Holiday\Provider\Switzerland\BaselLandschaft::class,
    'CH-BS' => \Umulmrum\Holiday\Provider\Switzerland\BaselStadt::class,
    'CH-FR' => \Umulmrum\Holiday\Provider\Switzerland\Fribourg::class,
    'CH-GE' => \Umulmrum\Holiday\Provider\Switzerland\Geneva::class,
    'CH-GL' => \Umulmrum\Holiday\Provider\Switzerland\Glarus::class,
    'CH-GR' => \Umulmrum\Holiday\Provider\Switzerland\Grisons::class,
    'CH-JU' => \Umulmrum\Holiday\Provider\Switzerland\Jura::class,
    'CH-LU' => \Umulmrum\Holiday\Provider\Switzerland\Lucerne::class,
    'CH-NE' => \Umulmrum\Holiday\Provider\Switzerland\Neuchatel::class,
    'CH-NW' => \Umulmrum\Holiday\Provider\Switzerland\Nidwalden::class,
    'CH-OW' => \Umulmrum\Holiday\Provider\Switzerland\Obwalden::class,
    'CH-SG' => \Umulmrum\Holiday\Provider\Switzerland\StGallen::class,
    'CH-SH' => \Umulmrum\Holiday\Provider\Switzerland\Schaffhausen::class,
    'CH-SO' => \Umulmrum\Holiday\Provider\Switzerland\Solothurn::class,
    'CH-SZ' => \Umulmrum\Holiday\Provider\Switzerland\Schwyz::class,
    'CH-TG' => \Umulmrum\Holiday\Provider\Switzerland\Thurgau::class,
    'CH-TI' => \Umulmrum\Holiday\Provider\Switzerland\Ticino::class,
    'CH-UR' => \Umulmrum\Holiday\Provider\Switzerland\Uri::class,
    'CH-VD' => \Umulmrum\Holiday\Provider\Switzerland\Vaud::class,
    'CH-VS' => \Umulmrum\Holiday\Provider\Switzerland\Valais::class,
    'CH-ZG' => \Umulmrum\Holiday\Provider\Switzerland\Zug::class,
    'CH-ZH' => \Umulmrum\Holiday\Provider\Switzerland\Zuerich::class,

    // Turkey
    'TR' => \Umulmrum\Holiday\Provider\Turkey\Turkey::class,

    // United Kingdom
    'GB' => \Umulmrum\Holiday\Provider\UnitedKingdom\UnitedKingdom::class,
    'GB-NIR' => \Umulmrum\Holiday\Provider\UnitedKingdom\NorthernIreland::class,
    'GB-SCT' => \Umulmrum\Holiday\Provider\UnitedKingdom\Scotland::class,

    // USA
    'US' => \Umulmrum\Holiday\Provider\Usa\Usa::class,
];
