#!/usr/bin/env bash

set -euxo pipefail

tests/console test:generate AT -y 1918 -y 1919 -y 1934 -y 1960 -y 1965 -y 1967
tests/console test:generate AT-1 -y 2020
tests/console test:generate AT-2 -y 1929 -y 1921
tests/console test:generate AT-3 -y 2020
tests/console test:generate AT-4 -y 2003 -y 2004
tests/console test:generate AT-5 -y 2020
tests/console test:generate AT-6 -y 2020
tests/console test:generate AT-7 -y 2020
tests/console test:generate AT-8 -y 2020
tests/console test:generate AT-9 -y 2020
tests/console test:generate BE -y 1865 -y 1866 -y 1890 -y 1973 -y 1975 -y 1990 -y 1998 -y 2020
tests/console test:generate BR -y 1889 -y 1890 -y 1949 -y 1980 -y 2020
tests/console test:generate DK -y 1848 -y 1849 -y 1891 -y 2020 -y 2024
tests/console test:generate FI -y 1950 -y 1955 -y 1991 -y 2024
tests/console test:generate FR -y 2004 -y 2019
tests/console test:generate FR-57 -y 2004 -y 2019
tests/console test:generate FR-67 -y 2004 -y 2019
tests/console test:generate FR-68 -y 2004 -y 2019
tests/console test:generate FR-GF -y 2004 -y 2019
tests/console test:generate FR-GUA -y 2004 -y 2019
tests/console test:generate FR-LRE -y 2004 -y 2019
tests/console test:generate FR-MQ -y 2004 -y 2019
tests/console test:generate DE -y 1970 -y 2019
tests/console test:generate DE-BB -y 2018
tests/console test:generate DE-BE -y 2018 -y 2019 -y 2020
tests/console test:generate DE-BW -y 2009 -y 2013 -y 2016
tests/console test:generate DE-BY -y 1968 -y 2016
tests/console test:generate DE-HB -y 2019
tests/console test:generate DE-HE -y 2016
tests/console test:generate DE-HH -y 2019
tests/console test:generate DE-MV -y 2020
tests/console test:generate DE-NI -y 2021
tests/console test:generate DE-NW -y 2022
tests/console test:generate DE-RP -y 2023
tests/console test:generate DE-SH -y 2019
tests/console test:generate DE-SL -y 2024
tests/console test:generate DE-SN -y 2016 -y 2017
tests/console test:generate DE-ST -y 2025
tests/console test:generate DE-TH -y 2018 -y 2025
tests/console test:generate GL -y 1984 -y 2020
tests/console test:generate IS -y 2024 -y 2025
tests/console test:generate IE -y 1870 -y 1902 -y 1974 -y 2011 -y 2019 -y 2020
tests/console test:generate IT -y 1911 -y 1945 -y 1946 -y 1950 -y 1961 -y 1977 -y 1985 -y 2001 -y 2011 -y 2020
tests/console test:generate IT-32 -y 2020
tests/console test:generate FL -y 2020
tests/console test:generate LU -y 1961 -y 2018 -y 2020
tests/console test:generate MX -y 1825 -y 1826 -y 1911 -y 1918 -y 1923 -y 2006 -y 2020
tests/console test:generate NL -y 1948 -y 1963 -y 1967 -y 1975 -y 1989 -y 1990 -y 2014 -y 2020
tests/console test:generate NO -y 2024
tests/console test:generate PL -y 1918 -y 1919 -y 1945 -y 1947 -y 2011 -y 2020
tests/console test:generate PT -y 1974 -y 1975 -y 2012 -y 2013 -y 2014 -y 2015 -y 2016 -y 2020
tests/console test:generate PT-20 -y 1980 -y 1981 -y 2024
tests/console test:generate PT-30 -y 1978 -y 1979 -y 2001 -y 2002 -y 2024
tests/console test:generate RU -y 1990 -y 1991 -y 1992 -y 2001 -y 2005 -y 2006 -y 2020
tests/console test:generate ES -y 1892 -y 1940 -y 2020
tests/console test:generate SE -y 2024 -y 2025
tests/console test:generate CH -y 1993 -y 2020
tests/console test:generate CH-AG -y 2017 -y 2020
tests/console test:generate CH-AI -y 2020
tests/console test:generate CH-AR -y 2017 -y 2020
tests/console test:generate CH-BE -y 2020
tests/console test:generate CH-BL -y 2020
tests/console test:generate CH-BS -y 2020
tests/console test:generate CH-FR -y 2020
tests/console test:generate CH-GE -y 1813 -y 2020
tests/console test:generate CH-GL -y 2020
tests/console test:generate CH-GR -y 2020
tests/console test:generate CH-JU -y 2020
tests/console test:generate CH-LU -y 2020
tests/console test:generate CH-NE -y 1847 -y 2016 -y 2017 -y 2020
tests/console test:generate CH-NW -y 2020
tests/console test:generate CH-OW -y 2020
tests/console test:generate CH-SG -y 2020
tests/console test:generate CH-SH -y 2020
tests/console test:generate CH-SO -y 2020
tests/console test:generate CH-SZ -y 2020
tests/console test:generate CH-TG -y 2020
tests/console test:generate CH-TI -y 2020
tests/console test:generate CH-UR -y 2020
tests/console test:generate CH-VD -y 2020
tests/console test:generate CH-VS -y 2020
tests/console test:generate CH-ZG -y 2020
tests/console test:generate CH-ZH -y 2020
tests/console test:generate TR -y 1962 -y 1963 -y 1981 -y 2016 -y 2017 -y 2014
tests/console test:generate GB -y 1964 -y 1968 -y 1969 -y 1973 -y 1977 -y 1981 -y 1995 -y 1999 -y 2002 -y 2011 -y 2012 -y 2020 -y 2022 -y 2023 -y 2024
tests/console test:generate GB-NIR -y 2014 -y 2018 -y 2020 -y 2024
tests/console test:generate GB-SCT -y 1967 -y 1968 -y 1973 -y 1977 -y 1981 -y 1995 -y 1999 -y 2006 -y 2011 -y 2012 -y 2020 -y 2021 -y 2022 -y 2023 -y 2024
tests/console test:generate US -y 1868 -y 1879 -y 1892 -y 1894 -y 1938 -y 1968 -y 1971 -y 1986 -y 2010 -y 2011
