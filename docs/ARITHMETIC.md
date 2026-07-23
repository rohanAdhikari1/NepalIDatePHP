# Arithmetic & Shifting

Methods for adding, subtracting, and shifting a `NepaliDate` to another point in time.

- [Add / Subtract](#-unit-operations-addsubtract)
- [Month overflow control](#month-overflow-control)
- [Dates difference](#dates-difference)
- [Shifting timezone](#timezone)
- [Shifting to a weekday](#week)

---

## ➕ Unit Operations (Add/Subtract)

| Unit   | Add Method                                                                | Subtract Method                                                           |
| ------ | -------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Year   | `addYear()`                                                                | `subYear()`                                                                 |
| Year   | `addYears($n)`                                                             | `subYears($n)`                                                              |
| Month  | `addMonth()` / `addMonthWithOverflow()` / `addMonthNoOverflow()`           | `subMonth()` / `subMonthWithOverflow()` / `subMonthNoOverflow()`             |
| Month  | `addMonths($n)` / `addMonthsWithOverflow($n)` / `addMonthsNoOverflow($n)`  | `subMonths($n)` / `subMonthsWithOverflow($n)` / `subMonthsNoOverflow($n)`     |
| Day    | `addDay()`                                                                 | `subDay()`                                                                  |
| Day    | `addDays($n)`                                                              | `subDays($n)`                                                               |
| Hour   | `addHour()`                                                                | `subHour()`                                                                 |
| Hour   | `addHours($n)`                                                             | `subHours($n)`                                                              |
| Minute | `addMinute()`                                                              | `subMinute()`                                                               |
| Minute | `addMinutes($n)`                                                           | `subMinutes($n)`                                                            |
| Second | `addSecond()`                                                              | `subSecond()`                                                               |
| Second | `addSeconds($n)`                                                           | `subSeconds($n)`                                                            |

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::now(); // Today: 2082-07-01
$nepaliDate->addYear();
echo $nepaliDate;
// Example Output: 2083-07-01 13:48:02

$nepaliDate->subMinute();
echo $nepaliDate;
// Example Output: 2083-07-01 13:48:15

$nepaliDate->subDays(5);
echo $nepaliDate;
// Example Output: 2083-06-27 13:48:49

$nepaliDate->addDays(10);
echo $nepaliDate;
// Example Output: 2083-07-07 13:50:25

// Or use the generic unit modifier
$nepaliDate->modifyUnit(NepaliUnit::Month, 2);
echo $nepaliDate;
// Example Output: 2083-08-27 13:49:24

$nepaliDate->modifyUnit(NepaliUnit::Month, -3);
echo $nepaliDate;
// Example Output: 2083-05-27 13:49:53
```

## Month overflow control

Month arithmetic supports explicit overflow behavior. Use the suffix methods for a single call, or configure the default globally with `NepaliDate::useMonthsOverflow(true)` / `NepaliDate::useMonthsOverflow(false)`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

NepaliDate::useMonthsOverflow(true); // enable month overflow globally

$date = NepaliDate::now();
$date->addMonthWithOverflow();
$date->addMonthNoOverflow();

$date->setMonthsOverflow(false); // override only for this instance
$date->resetMonthsOverflow();    // revert to the global setting
```

---

## Dates Difference

Currently, difference is available for English only — it converts both dates to AD and returns PHP's built-in `DateInterval`. Nepali-locale differences are planned for a future version.

```php
$date1 = NepaliDate::now();
$date2 = NepaliDate::now()->addDays(50);
$date1->diffAsDateInterval($date2); // returns a PHP DateInterval
```

---

## Shifting

Move a date to its corresponding value in a different timezone or week context.

### Timezone

```php
use RohanAdhikari\NepaliDate\NepaliDate;

// current timezone: Asia/Kathmandu
$nepaliDate = NepaliDate::now();
echo $nepaliDate->format(NepaliDate::FORMAT_ISO_8601);
// Example Output: 2082-07-01T11:41:22+05:45

// shift timezone to Australia
$nepaliDate->shiftTimezone('Australia/Melbourne');
echo $nepaliDate->format(NepaliDate::FORMAT_ISO_8601);
// Example Output: 2082-07-01T16:56:22+11:00
```

### Week

```php
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliWeekDay;

$nepaliDate = NepaliDate::parse('2082-07-02');

// shift to the previous Monday
$nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday, false);
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);

// shift to the next Monday
$nepaliDate->shiftToNearWeek(NepaliDate::MONDAY);
// or
$nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday);
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
```

**Next:** [Getters →](./GETTERS.md)
