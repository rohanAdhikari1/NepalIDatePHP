# 📏 Boundaries

Boundary methods snap a date/time to the start or end of a defined unit. Useful for:

- Rounding dates to the beginning or end of a day, week, month, or year.
- Performing date-range calculations for calendars.
- Filtering datasets by time ranges.

## Available Methods

| Method                      | Description                                                                                  |
| ----------------------------- | ------------------------------------------------------------------------------------------------ |
| `startOfDay()`                | Sets the time to the very beginning of the day (00:00:00).                                       |
| `endOfDay()`                  | Sets the time to the very end of the day (23:59:59).                                              |
| `startOfWeek($weekStart)`     | Moves the date to the first day of the week (Sunday by default, customizable).                     |
| `endOfWeek($weekEnd)`         | Moves the date to the last day of the week (Saturday by default, customizable).                    |
| `startOfMonth()`              | Moves the date to the first day of the month at 00:00:00.                                         |
| `endOfMonth()`                | Moves the date to the last day of the month at 23:59:59.                                          |
| `startOfQuarter()`            | Moves the date to the first day of the current quarter at 00:00:00.                               |
| `endOfQuarter()`              | Moves the date to the last day of the current quarter at 23:59:59.                                |
| `startOfYear()`               | Moves the date to the first day of the year at 00:00:00.                                          |
| `endOfYear()`                 | Moves the date to the last day of the year at 23:59:59.                                           |
| `startOfDecade()`             | Moves the date to the first year of the decade at 00:00:00.                                       |
| `endOfDecade()`               | Moves the date to the last year of the decade at 23:59:59.                                        |
| `startOfCentury()`            | Moves the date to the first year of the century at 00:00:00.                                      |
| `endOfCentury()`              | Moves the date to the last year of the century at 23:59:59.                                       |
| `startOfMillennium()`         | Moves the date to the first year of the millennium at 00:00:00.                                   |
| `endOfMillennium()`           | Moves the date to the last year of the millennium at 23:59:59.                                    |
| `startOfHour()`               | Sets minutes and seconds to 00:00 of the current hour.                                            |
| `endOfHour()`                 | Sets minutes and seconds to 59:59 of the current hour.                                            |
| `startOfMinute()`             | Sets seconds to 00 of the current minute.                                                         |
| `endOfMinute()`               | Sets seconds to 59 of the current minute.                                                         |
| `startOf(unit)`               | Generic method to snap the date to the start of a specified unit (day, month, year, etc.).        |
| `endOf(unit)`                 | Generic method to snap the date to the end of a specified unit (day, month, year, etc.).          |

## Examples

```php
use RohanAdhikari\NepaliDate\NepaliDateImmutable;
use RohanAdhikari\NepaliDate\NepaliUnit;

$nepaliDate = NepaliDateImmutable::now();

// end of century
echo $nepaliDate->endOfCentury(); // auto-converts to string using FORMAT_DATETIME_24_FULL
// Example Output: 2100-12-31 23:59:59

// start of decade
echo $nepaliDate->startOfDecade()->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
// Example Output: 2080/01/01

// start of quarter
echo $nepaliDate->startOf(NepaliUnit::Quarter)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example Output: 2082-07-01 00:00:00

// end of week
echo $nepaliDate->endOf(NepaliUnit::Week)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example Output: 2082-07-01 23:59:59
```

**Next:** [Comparison →](./COMPARISON.md)
