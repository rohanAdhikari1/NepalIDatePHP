# 🔎 Comparison

`NepaliDate` provides a comprehensive set of **comparison and state-checking methods**. Compare dates, check if a date falls within a range, or determine its temporal state (past, future, today, etc.). All methods accept either another `NepaliDateInterface` instance or a date string that can be parsed into a Nepali date.

| Method                                     | Alias / Shortcut                              | Description                                                                      |
| --------------------------------------------- | ------------------------------------------------- | ------------------------------------------------------------------------------------ |
| `equalTo($date)`                              | `eq($date)`                                       | Returns `true` if the current date is equal to the given date.                        |
| `notEqualTo($date)`                           | `ne($date)`                                       | Returns `true` if the current date is not equal to the given date.                    |
| `greaterThan($date)`                          | `gt($date)`, `isAfter($date)`                     | Returns `true` if the current date is after the given date.                           |
| `greaterThanOrEqualTo($date)`                 | `gte($date)`                                      | Returns `true` if the current date is after or equal to the given date.               |
| `lessThan($date)`                             | `lt($date)`, `isBefore($date)`                    | Returns `true` if the current date is before the given date.                          |
| `lessThanOrEqualTo($date)`                    | `lte($date)`                                      | Returns `true` if the current date is before or equal to the given date.              |
| `between($date1, $date2, $equal = true)`      | `isBetween($date1, $date2, $equal = true)`        | Returns `true` if the current date is between two dates (inclusive by default).       |
| `betweenIncluded($date1, $date2)`             | —                                                  | Returns `true` if the current date is between two dates, inclusive.                    |
| `betweenExcluded($date1, $date2)`             | —                                                  | Returns `true` if the current date is between two dates, exclusive.                    |
| `isWeekday()`                                 | —                                                  | Returns `true` if the current date is a weekday (not Saturday).                        |
| `isWeekend()`                                 | —                                                  | Returns `true` if the current date is a weekend (Saturday).                            |
| `isYesterday()`                               | —                                                  | Returns `true` if the current date represents yesterday.                               |
| `isToday()`                                   | —                                                  | Returns `true` if the current date represents today.                                   |
| `isTomorrow()`                                | —                                                  | Returns `true` if the current date represents tomorrow.                                |
| `isFuture()`                                  | —                                                  | Returns `true` if the current date is in the future.                                   |
| `isPast()`                                    | —                                                  | Returns `true` if the current date is in the past.                                     |
| `isNowOrFuture()`                             | —                                                  | Returns `true` if the current date is now or in the future.                            |
| `isNowOrPast()`                               | —                                                  | Returns `true` if the current date is now or in the past.                              |

## Examples

```php
use RohanAdhikari\NepaliDate\NepaliDate;

// Today's date: 2082-07-01
$nepaliDate = NepaliDate::parse('2082-07-02'); // Weekday: Sunday

var_dump($nepaliDate->eq('2082-07-02'));
// Output: bool(true)

var_dump($nepaliDate->gt('2082-07-02'));
// Output: bool(false)

var_dump($nepaliDate->gt(NepaliDate::now()));
// Output: bool(true)

var_dump($nepaliDate->lt(NepaliDate::now()));
// Output: bool(false)

var_dump($nepaliDate->between('2082-07-01', '2082-07-03'));
// Output: bool(true)

var_dump($nepaliDate->betweenExcluded('2082-07-01', '2082-07-02'));
// Output: bool(false)

var_dump($nepaliDate->betweenIncluded('2082-07-01', '2082-07-02'));
// Output: bool(true)

var_dump($nepaliDate->isPast());
// Output: bool(false)

var_dump($nepaliDate->isTomorrow());
// Output: bool(true)

var_dump($nepaliDate->isWeekday());
// Output: bool(true)

var_dump($nepaliDate->subDays(1)->isWeekend());
// Output: bool(true)
```

## Difference

`diffAsDateInterval()` converts both dates to AD and returns PHP's native `DateInterval` — see [Arithmetic & Shifting](./ARITHMETIC.md#dates-difference).

```php
$date1 = NepaliDate::now();
$date2 = NepaliDate::now()->addDays(50);
$date1->diffAsDateInterval($date2); // DateInterval
```

**See also:** [Boundaries](./BOUNDARIES.md) for start/end-of-unit snapping used alongside range comparisons.
