# Calendar

`RohanAdhikari\NepaliDate\Constants\Calendar` is the low-level lookup table and math behind every AD ⇄ BS conversion in this package. Most applications never need it directly — `NepaliDate` already wraps it — but it's public and useful when you need calendar facts (days in a month, leap years, day-of-week math) without constructing a full date instance.

> [!NOTE]
> The BS day-length table only covers years `1900`–`2101` (see `Calendar::START_YEAR_BS` / `Calendar::END_YEAR_BS`). Dates outside that range throw `NepaliDateOutOfBoundsException` — see [Exceptions](./EXCEPTIONS.md).

## Available Methods

| Method                                                     | Description                                                                 |
| -------------------------------------------------------------| ------------------------------------------------------------------------------ |
| `isLeapYear(int $year): bool`                                | Whether the given **AD** year is a leap year.                                 |
| `getDaysInBSMonth(int $year, int $month): int`               | Number of days in a given BS year/month (29–32).                              |
| `getDaysInADMonth(int $year, int $month): int`               | Number of days in a given AD year/month (28–31).                              |
| `getTotalBSDays(int $year, int $month, int $day): int`       | Total days elapsed since `Calendar::BASE_YEAR_BS` up to the given BS date.    |
| `getTotalADDays(int $year, int $month, int $day): int`       | Total days elapsed since `Calendar::BASE_YEAR_AD` up to the given AD date.    |
| `getDayOfWeek(int $totalDays): int`                          | Weekday (1 = Sunday … 7 = Saturday) for a BS day count.                       |
| `getDayOfWeekFromAD(int $totalDays): int`                    | Weekday (1 = Sunday … 7 = Saturday) for an AD day count.                      |
| `calculateDayOfWeek(int $year, int $month, int $day): int`   | Weekday for a given BS date — used internally by every `NepaliDate` instance. |

## Examples

```php
use RohanAdhikari\NepaliDate\Constants\Calendar;

Calendar::getDaysInBSMonth(2082, 1);   // 31 — days in Baisakh 2082
Calendar::isLeapYear(2028);            // true — 2028 AD is a leap year
Calendar::calculateDayOfWeek(2082, 7, 1); // e.g. 4 (Wednesday)
```

## Useful Constants

| Constant                | Meaning                                                  |
| -------------------------| ------------------------------------------------------------ |
| `START_YEAR_BS` / `END_YEAR_BS` | Supported BS year range (`1900`–`2101`).                 |
| `START_YEAR_AD`          | Earliest AD year the package can convert to/from.          |
| `NEPALI_DATES`            | Raw `[year => [days per month]]` lookup table for BS years. |
| `NORMAL_MONTHS` / `LEAP_MONTHS` | Days-per-month for non-leap / leap AD years.        |

For the higher-level, date-instance API (formatting, arithmetic, comparisons), see the [main README](../README.md).
