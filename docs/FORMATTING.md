# Formatting

`format()` renders a `NepaliDate` instance according to a pattern of tokens, similar to PHP's native `date()`. You can pass a custom pattern or one of the predefined constants — see [Constants](./CONSTANTS.md#date-formats).

## Format Tokens

| Format | Output Example                   | Meaning                                 |
| ------ | --------------------------------- | ---------------------------------------- |
| Y      | 2082                              | Year                                     |
| y      | 82                                | Two-digit year                           |
| m      | 02                                | Month, two digits                        |
| n      | 2                                 | Month (1–12)                             |
| M      | Bai                               | Short month name                         |
| F      | Baisakh                           | Full month name                          |
| d      | 09                                | Two-digit day                            |
| j      | 9                                 | Day                                      |
| D      | Sun                               | Short weekday name                       |
| l      | Sunday                            | Full weekday name                        |
| w      | 1                                 | Weekday number (Sunday=1, Monday=2…)     |
| G      | 7                                 | Hour, 24-hour clock                      |
| H      | 07                                | Hour, 24-hour clock, 2-digits            |
| h      | 23                                | Hour, 12-hour clock                      |
| g      | 12                                | Hour, 12-hour clock, 2-digits            |
| a      | am / pm                           | Meridiem (lowercase)                     |
| A      | AM / PM                           | Meridiem (uppercase)                     |
| i      | 59                                | Minute, 2-digits                         |
| s      | 59                                | Second, 2-digits                         |
| e      | Asia/Kathmandu                    | Timezone name                            |
| O      | +0530                             | Timezone offset                          |
| P      | +05:45                            | Timezone offset with colon               |
| Z      | 20700                             | Timezone offset in seconds               |
| c      | 2082-02-01T14:30:00+05:45         | ISO 8601 datetime                        |
| r      | Sun, 01 Bai 2082 14:30:00 +0530   | RFC 2822 datetime                        |
| U      | 1675289400                        | Unix timestamp (using AD date and time)  |

## Examples

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$date = NepaliDate::now();

// Using a predefined format (24-hour datetime)
echo $date->format(NepaliDate::FORMAT_DATETIME_24);
// Example output: 2082-06-31 21:14

// Using a custom format string
echo $date->format('Y-m-d H:i');
// Example output: 2082-06-31 21:14

// Using full month name + weekday
echo $date->format('l, F j, Y');
// Example output: Friday, Ashwin 31, 2082

// Using ISO 8601 format
echo $date->format('c');
// Example output: 2082-06-31T21:14:14+05:45

// Using RFC 2822 format
echo $date->format('r');
// Example output: Fri, 31 Asw 2082 21:14:14 +0545
```

`(string) $date` and `echo $date` both fall back to `FORMAT_DATETIME_24_FULL`.

## Locale-Aware Formatting

Formatting respects the instance's [locale](../README.md#-locale). Set `np` to render tokens like `Y`, `m`, `d`, month/weekday names, etc. in Nepali:

```php
$date->locale('np');
echo $date->format(NepaliDate::FORMAT_DATETIME_24);
// Example output: २०८२-०६-३१ २१:३४
```

See the [Getters](./GETTERS.md#locale-based) doc for the full list of locale-aware accessor methods, and [Nepali Numbers](./NEPALINUMBERS.md) for standalone digit/currency conversion.

**Next:** [Parsing →](./PARSING.md)
