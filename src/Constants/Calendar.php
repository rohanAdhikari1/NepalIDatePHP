<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Constants;

final class Calendar
{
    public const BASE_YEAR_BS = 1900;

    public const START_YEAR_BS = 1900;

    public const START_MONTH_BS = 9;

    public const START_DAY_BS = 17;

    public const START_WEEK_DAY_BS = 7;

    public const BASE_YEAR_AD = 1844;

    public const START_YEAR_AD = 1843;

    public const START_MONTH_AD = 4;

    public const START_DAY_AD = 13;

    public const START_WEEK_DAY_AD = 5;

    public const END_YEAR_BS = 2100;

    public const NEPALI_DATES = [
        1899 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1900 => [31, 32, 31, 32, 31, 30, 30, 30, 30, 29, 29, 30],
        1901 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1902 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1903 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1904 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1905 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1906 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1907 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1908 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1909 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1910 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1911 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1912 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1913 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1914 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1915 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1916 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1917 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1918 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        1919 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1920 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1921 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1922 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1923 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1924 => [30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31],
        1925 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1926 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1927 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1928 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1929 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1930 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1931 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1932 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1933 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1934 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1935 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1936 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1937 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1938 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1939 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1940 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1941 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1942 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1943 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1944 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1945 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1946 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1947 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1948 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1949 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1950 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1951 => [30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31],
        1952 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1953 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1954 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1955 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1956 => [31, 31, 32, 31, 31, 31, 30, 30, 30, 29, 30, 30],
        1957 => [31, 31, 32, 31, 31, 31, 30, 29, 29, 29, 30, 31],
        1958 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1959 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1960 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1961 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1962 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1963 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1964 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1965 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1966 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1967 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1968 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1969 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1970 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1971 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1972 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1973 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1974 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1975 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1976 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1977 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1978 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1979 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1980 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1981 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1982 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1983 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1984 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1985 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1986 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1987 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1988 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1989 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        1990 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        1991 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1992 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        1993 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1994 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        1995 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1996 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        1997 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        1998 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        1999 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2000 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2001 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2002 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2003 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2004 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2005 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2006 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2007 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2008 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        2009 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2010 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2011 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2012 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        2013 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2014 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2015 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2016 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        2017 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2018 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2019 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2020 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2021 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2022 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        2023 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2024 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2025 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2026 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2027 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2028 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2029 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2030 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2031 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2032 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2033 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2034 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2035 => [30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        2036 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2037 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2038 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2039 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        2040 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2041 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2042 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2043 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        2044 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2045 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2046 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2047 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2048 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2049 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        2050 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2051 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2052 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2053 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        2054 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2055 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2056 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2057 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2058 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2059 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2060 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2061 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2062 => [30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31],
        2063 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2064 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2065 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2066 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31],
        2067 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2068 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2069 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2070 => [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30],
        2071 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2072 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2073 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2074 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2075 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2076 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        2077 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2078 => [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30],
        2079 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2080 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30],
        2081 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2082 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2083 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2084 => [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        2085 => [31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        2086 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        2087 => [31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30],
        2088 => [30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30],
        2089 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        2090 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        2091 => [31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30],
        2092 => [30, 31, 32, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        2093 => [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        2094 => [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30],
        2095 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 30, 30, 30],
        2096 => [30, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2097 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30],
        2098 => [31, 31, 32, 31, 31, 31, 29, 30, 29, 30, 29, 31],
        2099 => [31, 31, 32, 31, 31, 31, 30, 29, 29, 30, 30, 30],
        2100 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2101 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
    ];

    public const NORMAL_MONTHS = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    public const LEAP_MONTHS = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    /**
     * Days before the 1st of each AD month (index = month - 1).
     */
    private const DAYS_BEFORE_AD_MONTH = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

    private const DAYS_BEFORE_AD_MONTH_LEAP = [0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335];

    /**
     * First BS year in {@see NEPALI_DATES}. Day number 0 is 1 Baisakh of this year;
     * every AD and BS date is placed on that single shared day count.
     */
    private const EPOCH_YEAR_BS = 1899;

    /**
     * Day number of 1 Baisakh {@see START_YEAR_BS} (= {@see START_YEAR_AD}-{@see START_MONTH_AD}-{@see START_DAY_AD}).
     */
    private static int $bsStartDayNumber = 0;

    /**
     * Day number of 1 January {@see BASE_YEAR_AD}, the epoch of {@see getTotalADDays()}.
     */
    private static int $adBaseDayNumber = 0;

    /**
     * Shift that places proleptic-Gregorian day counts on the shared day count.
     */
    private static int $adDayNumberOffset = 0;

    /**
     * BS year => [day number of the 1st of month 1..12, then the 1st of the next year].
     *
     * @var array<int, list<int>>
     */
    private static array $bsMonthStarts = [];

    public static function isLeapYear(int $year): bool
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
    }

    public static function getDaysInBSMonth(int $year, int $month): int
    {
        return self::NEPALI_DATES[$year][$month - 1];
    }

    /**
     * Day count where 1 Baisakh {@see START_YEAR_BS} is day 1.
     */
    public static function getTotalBSDays(int $year, int $month, int $day): int
    {
        return self::bsDayNumber($year, $month, $day) - self::$bsStartDayNumber + 1;
    }

    public static function getDayOfWeek(int $totalDays): int
    {
        return ((self::START_WEEK_DAY_AD - 2 + $totalDays) % 7) + 1;
    }

    public static function getDayOfWeekFromAD(int $totalDays): int
    {
        return ((self::START_WEEK_DAY_BS - 2 + $totalDays) % 7) + 1;
    }

    /**
     * Day of week (1 = Sunday … 7 = Saturday) of a BS date.
     */
    public static function calculateDayOfWeek(int $year, int $month, int $day): int
    {
        return self::dayOfWeekFromDayNumber(self::bsDayNumber($year, $month, $day));
    }

    public static function getDaysInADMonth(int $year, int $month): int
    {
        return self::isLeapYear($year) ? self::LEAP_MONTHS[$month - 1] : self::NORMAL_MONTHS[$month - 1];
    }

    /**
     * Day count where 1 January {@see BASE_YEAR_AD} is day 1 (dates in earlier years are <= 0).
     */
    public static function getTotalADDays(int $year, int $month, int $day): int
    {
        return self::adDayNumber($year, $month, $day) - self::$adBaseDayNumber + 1;
    }

    /**
     * Shared day number of a BS date. Expects a date inside {@see NEPALI_DATES}.
     *
     * @internal used by the converter; not part of the public API
     */
    public static function bsDayNumber(int $year, int $month, int $day): int
    {
        if (! self::$bsMonthStarts) {
            self::buildTables();
        }

        return self::$bsMonthStarts[$year][$month - 1] + $day - 1;
    }

    /**
     * Shared day number of an AD (proleptic Gregorian) date. Works for any year.
     *
     * @internal used by the converter; not part of the public API
     */
    public static function adDayNumber(int $year, int $month, int $day): int
    {
        if (! self::$bsMonthStarts) {
            self::buildTables();
        }
        $daysBeforeMonth = self::isLeapYear($year) ? self::DAYS_BEFORE_AD_MONTH_LEAP : self::DAYS_BEFORE_AD_MONTH;

        return self::gregorianDaysBeforeYear($year) + $daysBeforeMonth[$month - 1] + $day - 1 + self::$adDayNumberOffset;
    }

    /**
     * BS date for a shared day number. Expects a day number inside {@see NEPALI_DATES}.
     *
     * @internal used by the converter; not part of the public API
     *
     * @return array{int,int,int} [year, month, day]
     */
    public static function bsDateFromDayNumber(int $dayNumber): array
    {
        if (! self::$bsMonthStarts) {
            self::buildTables();
        }

        // Estimate the year, then correct by at most a step either way.
        $year = self::EPOCH_YEAR_BS + intdiv($dayNumber, 366);
        while (self::$bsMonthStarts[$year][0] > $dayNumber) {
            $year--;
        }
        while (self::$bsMonthStarts[$year][12] <= $dayNumber) {
            $year++;
        }

        $starts = self::$bsMonthStarts[$year];
        $month = 1;
        while ($starts[$month] <= $dayNumber) {
            $month++;
        }

        return [$year, $month, $dayNumber - $starts[$month - 1] + 1];
    }

    /**
     * AD (proleptic Gregorian) date for a shared day number.
     *
     * @internal used by the converter; not part of the public API
     *
     * @return array{int,int,int} [year, month, day]
     */
    public static function adDateFromDayNumber(int $dayNumber): array
    {
        if (! self::$bsMonthStarts) {
            self::buildTables();
        }
        $gregorianDay = $dayNumber - self::$adDayNumberOffset;

        // Estimate the year, then correct by at most a step either way.
        $year = intdiv($gregorianDay * 400, 146097) + 1;
        while (self::gregorianDaysBeforeYear($year) > $gregorianDay) {
            $year--;
        }
        while (self::gregorianDaysBeforeYear($year + 1) <= $gregorianDay) {
            $year++;
        }

        $dayOfYear = $gregorianDay - self::gregorianDaysBeforeYear($year);
        $daysBeforeMonth = self::isLeapYear($year) ? self::DAYS_BEFORE_AD_MONTH_LEAP : self::DAYS_BEFORE_AD_MONTH;
        $month = 12;
        while ($daysBeforeMonth[$month - 1] > $dayOfYear) {
            $month--;
        }

        return [$year, $month, $dayOfYear - $daysBeforeMonth[$month - 1] + 1];
    }

    /**
     * Day of week (1 = Sunday … 7 = Saturday) for a shared day number.
     * Anchored on 1 Baisakh {@see START_YEAR_BS}, which is weekday {@see START_WEEK_DAY_AD}.
     *
     * @internal used by the converter; not part of the public API
     */
    public static function dayOfWeekFromDayNumber(int $dayNumber): int
    {
        if (! self::$bsMonthStarts) {
            self::buildTables();
        }

        return (($dayNumber - self::$bsStartDayNumber + self::START_WEEK_DAY_AD - 1) % 7 + 7) % 7 + 1;
    }

    /**
     * Days from 1 January of year 1 (proleptic Gregorian) to 1 January of $year.
     */
    private static function gregorianDaysBeforeYear(int $year): int
    {
        $y = $year - 1;

        return 365 * $y + intdiv($y, 4) - intdiv($y, 100) + intdiv($y, 400);
    }

    /**
     * Builds every lookup table in one pass, once per process (~200 years, a few KB).
     */
    private static function buildTables(): void
    {
        $starts = [];
        $dayNumber = 0;
        foreach (self::NEPALI_DATES as $year => $months) {
            $row = [];
            foreach ($months as $daysInMonth) {
                $row[] = $dayNumber;
                $dayNumber += $daysInMonth;
            }
            $row[] = $dayNumber;
            $starts[$year] = $row;
        }

        self::$bsStartDayNumber = $starts[self::START_YEAR_BS][0];

        // 1 Baisakh START_YEAR_BS falls on START_YEAR_AD-START_MONTH_AD-START_DAY_AD.
        $daysBeforeMonth = self::isLeapYear(self::START_YEAR_AD) ? self::DAYS_BEFORE_AD_MONTH_LEAP : self::DAYS_BEFORE_AD_MONTH;
        $anchorGregorianDay = self::gregorianDaysBeforeYear(self::START_YEAR_AD)
            + $daysBeforeMonth[self::START_MONTH_AD - 1] + self::START_DAY_AD - 1;
        self::$adDayNumberOffset = self::$bsStartDayNumber - $anchorGregorianDay;
        self::$adBaseDayNumber = self::gregorianDaysBeforeYear(self::BASE_YEAR_AD) + self::$adDayNumberOffset;

        self::$bsMonthStarts = $starts;
    }
}
