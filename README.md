# NepaliDate

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rohanadhikari/nepali-date.svg?style=flat-square)](https://packagist.org/packages/rohanadhikari/nepali-date)
[![Total Downloads](https://img.shields.io/packagist/dt/rohanadhikari/nepali-date.svg?style=flat-square)](https://packagist.org/packages/rohanadhikari/nepali-date)

A PHP package for handling **Nepali Date and Time (Bikram Sambat - BS)** with full support for localization, date manipulation, and formatting. All calculations are based on the **Nepali calendar**, making it perfect for applications targeting Nepali users or systems that operate primarily in BS.

---

> [!NOTE]  
> v1-beta is optimized for fast date conversions by minimizing computational overhead. Additional optimization steps are planned. You can try v1-beta and share your feedback to help improve it.

---

## 🚀 Features

- 🕒 Works in **Nepali (BS) date and time**
- 🗓 Simple functions to **convert between AD & BS**
- 🔁 Support for **mutable** and **immutable** date handling
- ➕ Add or subtract days, months, and years in BS
- 📅 Get current Nepali date and time
- 🌐 Customizable **locale** (Nepali or English)
- 🔢 Format dates in various display styles
- ⚙️ Compare, parse, and format dates easily
- 🧩 Integration-ready with Laravel and other frameworks

---

## 📦 Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require rohanadhikari/nepali-date
```

---

## Usage

```php
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

// -----------------------------
// Mutable NepaliDate
// -----------------------------
$now = NepaliDate::now(); // Current Nepali date and time

$date = NepaliDate::fromNotation('tomorrow'); // Parse a notation
$date->addDays(5);                            // Add 5 days

$adDate = $date->toAd();                       // Convert to Gregorian (AD)

$formatted = $date->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example: 2082-06-30 14:45:22

// -----------------------------
// Immutable NepaliDate
// -----------------------------
$immutableNow = NepaliDateImmutable::now();   // Immutable current date

$immutableDate = $date->cast();               // Cast mutable to immutable and vice versa
// or
$immutableDate = $date->toImmutable();

$newDate = $immutableDate->addDays(10);       // Returns a new instance, original remains unchanged
```

> [!NOTE]  
> You can see the available constants [here](./docs/CONSTANTS.md)

## Using in native PHP (no framework)

If you're not using a framework, you can still use this package in plain PHP. The easiest way is to install via Composer and include the generated autoloader.

```php
// Require Composer's autoloader (adjust path as needed)
require __DIR__ . '/vendor/autoload.php';

use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

// -----------------------------
// Mutable example
// -----------------------------
$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_24_FULL);

// -----------------------------
// Immutable example
// -----------------------------
$immutable = NepaliDateImmutable::now();
$new = $immutable->addDays(5); // returns a new instance
echo $new->format(NepaliDate::FORMAT_DATE_YMD);

// -----------------------------
// Create from native DateTime (AD)
// -----------------------------
$ad = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));
$fromAd = NepaliDate::fromAd($ad);
echo $fromAd->format(NepaliDate::FORMAT_DATE_YMD);
```

Notes:

- Make sure the path to `vendor/autoload.php` is correct relative to your script.
- Composer is the recommended way to load the package. If you don't use Composer you need to include the package files manually (not recommended).

---

## ⚙️ Initialize

Create a new **NepaliDate** instance in different ways depending on your use case.

---

### Now

Returns a `NepaliDate` instance initialized with the **current Nepali date and time**.

**Parameters:**

- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_12_FULL); // 2082-06-30 10:09:38 PM
//you can also specify timezone as
$now = NepaliDate::now('Asia/Kathmandu');
//or
$timezone = new DateTimeZone('Asia/Kathmandu');
NepaliDate::now($timezone);
```

---

### Using PHP Native DateTime

Create a `NepaliDate` instance directly from a PHP native `DateTime` (AD).  
This automatically converts the **Gregorian (AD)** date into the **Nepali (BS)** calendar.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
$date = new DateTime();
$nepalidate = NepaliDate::fromAd($date);
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // 2082-06-30
```

---

### Using DateTime Notation

Create a `NepaliDate` instance using a **natural language date string** (like `'now'`, `'yesterday'`, `'tomorrow'`).  
This internally parses the notation using Native DateTime and converts it into a corresponding **Nepali (BS)** date.

- `notation` — A date string supported by PHP’s native `DateTime` parser (e.g., `'now'`, `'yesterday'`, `'2025-01-01'`, `'next monday'`).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

**Example**

```php
use RohanAdhikari\NepaliDate\NepaliDate;
// Create NepaliDate for tomorrow and format it
$nepaliDate = NepaliDate::fromNotation('tomorrow');

echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // e.g. 2082-06-31
```

---

### Using Unix Timestamp

Create a `NepaliDate` instance from a **Unix timestamp**.  
This method first converts the timestamp into a PHP `DateTime` object and then translates it into the equivalent **Nepali (BS)** date and time.

**Parameters**

- `timestamp` — A valid Unix timestamp (seconds since Unix epoch).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.
  **Example**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::fromTimestamp(1760632252);

echo $nepaliDate->format(NepaliDate::FORMAT_DATETIME_24_FULL); // e.g. 2082-06-30 22:15:52
```

---

### Direct

Manually create a new `NepaliDate` instance by providing all date components.

**Parameters**

- `year` - Nepali year (e.g. `2082`)
- `month` - Nepali month number (`1–12`)
- `day` — Day of month (`1–32`, varies by **year** and **month**)
- `hour` _(optional)_ — Defaults to `0`
- `minute` _(optional)_ — Defaults to `0`
- `second` _(optional)_ — Defaults to `0`
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepalidate = new NepaliDate(2082,6,30,timezone:'Asia/kathmandu')
```

---

## Format

Formats the `NepaliDate` instance according to the provided pattern and locale-specific rules, and returns a string of the formatted date. You can also use predefined fromat pattern from [Constants](./docs/CONSTANTS.md#date-formats).

**List of Available Formats Tokens**

| Format | Output Example                  | Meaning                                 |
| ------ | ------------------------------- | --------------------------------------- |
| Y      | 2082                            | Year                                    |
| y      | 82                              | Two-digit year                          |
| m      | 2                               | Month (1–12)                            |
| n      | 02                              | Month, two digits                       |
| M      | Bai                             | Short month name                        |
| F      | Baisakh                         | Full month name                         |
| d      | 09                              | Two-digit day                           |
| j      | 9                               | Day                                     |
| D      | Sun                             | Short weekday name                      |
| l      | Sunday                          | Full weekday name                       |
| w      | 1                               | Weekday number (Sunday=1, Monday=2…)    |
| G      | 7                               | Hour, 24-hour clock                     |
| H      | 07                              | Hour, 24-hour clock, 2-digits           |
| h      | 23                              | Hour, 12-hour clock                     |
| g      | 12                              | Hour, 12-hour clock, 2-digits           |
| a      | am / pm                         | Meridiem (lowercase)                    |
| A      | AM / PM                         | Meridiem (uppercase)                    |
| i      | 59                              | Minute, 2-digits                        |
| s      | 59                              | Second, 2-digits                        |
| e      | Asia/Kathmandu                  | Timezone name                           |
| O      | +0530                           | Timezone offset                         |
| P      | +05:45                          | Timezone offset with colon              |
| Z      | 20700                           | Timezone offset in seconds              |
| c      | 2082-02-01T14:30:00+05:45       | ISO 8601 datetime                       |
| r      | Sun, 01 Bai 2082 14:30:00 +0530 | RFC 2822 datetime                       |
| U      | 1675289400                      | Unix timestamp (Using Ad Date and Time) |

**Example:**

```php
    use RohanAdhikari\NepaliDate\NepaliDate;
    // Get the current Nepali date and time
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

---

## 🌐 Locale

Available locales: `en` and `np`.

**Example:**

```php
    use RohanAdhikari\NepaliDate\NepaliDate;

    $date = NepaliDate::now();
    $date->setLocale(NepaliDate::NEPALI); //Using defined constant
    //or
    $date->locale('np');
    //or
    $date->locale = 'np'; //Not supported for ImmmutableNepaliDate

    echo $date->format(NepaliDate::FORMAT_DATETIME_24);
    //Example Output: २०८२-०६-३१ २१:३४

    //for reset
    $date->resetLocale();
```

> [!Note]
> You can also set the global default locale as:-
>
> ```php
> NepaliDate::defaultLocale(NepaliDate::NEPALI);
> ```
>
> Any new instance of `NepaliDate` will now use this locale by default.

---

## Parse

The `NepaliDate` class provides the `parse()` method, which allows you to create a NepaliDate instance from a string. It supports multiple default format patterns, and you can also add custom parse patterns to handle other string formats or use [`createFromFormat`](#Createfromformat).

**Default format patterns supported for parsing:**

| Format Pattern    |
| ----------------- |
| `Y-m-d`           |
| `Y-n-d`           |
| `Y-m-d H:i:s`     |
| `Y-m-d h:i:s A`   |
| `h:i A`           |
| `h:i:s A`         |
| `H:i`             |
| `H:i:s`           |
| `U`               |
| `c`               |
| `r`               |
| `D, d M Y H:i:s`  |
| `l, F j, Y g:i A` |

**Example:**

```php
    use RohanAdhikari\NepaliDate\NepaliDate;

    $nepalidate = NepaliDate::parse('2080-06-02');

    $nepalidate = NepaliDate::parse('2080-6-02');

    $nepalidate = NepaliDate::parse('13:12');

    //adding new custom parse pattern
    NepaliDate::addDefaultParserFormat('j F, Y');
    NepaliDate::parse('1 Kartik, 2082');

    //also can add multple custom parse format at once
    NepaliDate::addDefaultParserFormats(['j F, Y', 'j M, Y']);
```

---

## CreateFromFormat

The `NepaliDate` class provides the `createFromFormat()` method, which allows you to create a NepaliDate instance from a string using a specific format.

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::createFromFormat('j F, Y', '1 Kartik, 2082');

$nepaliDate = NepaliDate::createFromFormat('Y-m-d H:i:s', '2080-07-01 14:30:00');

$nepaliDate = NepaliDate::createFromFormat('h:i A', '02:45 PM');
```

---

## ➕ Unit Operations (Add/Subtract)

**Available Methods**

| Unit   | Add Method                                                                | Subtract Method                                                           |
| ------ | ------------------------------------------------------------------------- | ------------------------------------------------------------------------- |
| Year   | `addYear()`                                                               | `subYear()`                                                               |
| Year   | `addYears($n)`                                                            | `subYears($n)`                                                            |
| Month  | `addMonth()` / `addMonthWithOverflow()` / `addMonthNoOverflow()`          | `subMonth()` / `subMonthWithOverflow()` / `subMonthNoOverflow()`          |
| Month  | `addMonths($n)` / `addMonthsWithOverflow($n)` / `addMonthsNoOverflow($n)` | `subMonths($n)` / `subMonthsWithOverflow($n)` / `subMonthsNoOverflow($n)` |
| Day    | `addDay()`                                                                | `subDay()`                                                                |
| Day    | `addDays($n)`                                                             | `subDays($n)`                                                             |
| Hour   | `addHour()`                                                               | `subHour()`                                                               |
| Hour   | `addHours($n)`                                                            | `subHours($n)`                                                            |
| Minute | `addMinute()`                                                             | `subMinute()`                                                             |
| Minute | `addMinutes($n)`                                                          | `subMinutes($n)`                                                          |
| Second | `addSecond()`                                                             | `subSecond()`                                                             |
| Second | `addSeconds($n)`                                                          | `subSeconds($n)`                                                          |

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

    $nepalidate = NepaliDate::now(); //Today: 2082-07-01
    $nepalidate->addYear();
    echo $nepalidate;
    //Example Output: 2083-07-01 13:48:02
    $nepalidate->subMinute();
    echo $nepalidate;
    //Example Output: 2083-07-01 13:48:15
    $nepalidate->subDays(5);
    echo $nepalidate;
    //Example Output: 2083-06-27 13:48:49
    $nepalidate->addDays(10);
    echo $nepalidate;
    //Example Output: 2083-07-07 13:50:25

    //or also you use
    $nepalidate->modifyUnit(NepaliUnit::Month, 2);
    echo $nepalidate;
    //Example Output: 2083-08-27 13:49:24
    $nepalidate->modifyUnit(NepaliUnit::Month, -3);
    echo $nepalidate;
    //Example Output: 2083-05-27 13:49:53

```

### Month overflow control

Month arithmetic now supports explicit overflow behavior. Use the suffix methods for a single call, or configure the default globally with `NepaliDate::useMonthsOverflow(true)` / `NepaliDate::useMonthsOverflow(false)`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

NepaliDate::useMonthsOverflow(true); // enable month overflow globally

$date = NepaliDate::now();
$date->addMonthWithOverflow();
$date->addMonthNoOverflow();

$date->setMonthsOverflow(false); // override only for this instance
$date->resetMonthsOverflow(); // revert to the global setting
```

---

## Dates Difference

Currently this difference feature is avialable for english only as it just convert date into AdDate and return builtin DateInterval instance. But feature for nepali locale will be avialble in future version.
**Example:**

```php
    $date1 = NepaliDate::now();
    $date2 = NepaliDate::now()->addDays(50);
    $date1->diff($date2); //will return php built in DateInterval.
```

---

## 🔍 Getters

### 🕰️ Year / Era

| Method            | Description                          | Example          |
| ----------------- | ------------------------------------ | ---------------- |
| `getMillennium()` | Returns millennium number .          | `3` → for `2082` |
| `getCentury()`    | Returns century number .             | `21`             |
| `getDecade()`     | Returns decade number .              | `209`            |
| `getYear()`       | Returns full year.                   | `2082`           |
| `getShortYear()`  | Returns last two digits of the year. | `"82"`           |

---

### ⏰ Time (24-hour)

| Method                | Description                    | Example |
| --------------------- | ------------------------------ | ------- |
| `getHour()`           | Hour in 24-hour format (0–23). | `14`    |
| `getTwoDigitHour()`   | Two-digit 24-hour format.      | `"14"`  |
| `getMinute()`         | Minute (0–59).                 | `45`    |
| `getTwoDigitMinute()` | Two-digit minute string.       | `"45"`  |
| `getSecond()`         | Second (0–59).                 | `9`     |
| `getTwoDigitSecond()` | Two-digit second string.       | `"09"`  |

---

### 📆 Day

| Method             | Description                              | Example |
| ------------------ | ---------------------------------------- | ------- |
| `getDay()`         | Day of the month.                        | `12`    |
| `getTwoDigitDay()` | Two-digit day string.                    | `"12"`  |
| `getWeekDay()`     | Day of week (1 = Sunday → 7 = Saturday). | `1`     |

---

### 📅 Month

| Method               | Description                       | Example |
| -------------------- | --------------------------------- | ------- |
| `getMonth()`         | Month number (1–12).              | `5`     |
| `getTwoDigitMonth()` | Two-digit month.                  | `"05"`  |
| `getQuarter()`       | Returns quarter number (1–4).     | `2`     |
| `getDaysInMonth()`   | Total days in the given BS month. | `32`    |

---

### 🕛 Time (12-hour)

| Method                   | Description               | Example |
| ------------------------ | ------------------------- | ------- |
| `getShortHour()`         | Hour in 12-hour format.   | `2`     |
| `getTwoDigitShortHour()` | Two-digit 12-hour format. | `"02"`  |
| `getMaridian()`          | Returns `"AM"` or `"PM"`. | `"PM"`  |

---

### 🌍 Timezone

| Method              | Description                    | Example                          |
| ------------------- | ------------------------------ | -------------------------------- |
| `getTimezone()`     | Returns timezone object.       | `DateTimeZone('Asia/Kathmandu')` |
| `getTimezoneName()` | Returns timezone name.         | `"Asia/Kathmandu"`               |
| `getTZName()`       | Alias for `getTimezoneName()`. | `"Asia/Kathmandu"`               |

---

### 🈯 Locale-Based

| Method                         | Description                          | Example Output (Nepali) |
| ------------------------------ | ------------------------------------ | ----------------------- |
| `getLocale()`                  | Current Locale.                      | `"np"`                  |
| `getLocaleMillennium()`        | Localized millennium number.         | `"३"`                   |
| `getLocaleCentury()`           | Localized century number.            | `"२१"`                  |
| `getLocaleDecade()`            | Localized decade number.             | `"२०९"`                 |
| `getLocaleYear()`              | Localized year.                      | `"२०८२"`                |
| `getLocaleShortYear()`         | Localized short year.                | `"८२"`                  |
| `getLocaleQuarter()`           | Localized quarter number.            | `"२"`                   |
| `getLocaleMonth()`             | Localized month number.              | `"५"`                   |
| `getLocaleTwoDigitMonth()`     | Localized two-digit month.           | `"०५"`                  |
| `getLocaleMonthName()`         | Localized month name.                | `"बैशाख"`               |
| `getLocaleShortMonthName()`    | Localized short month name.          | `"बै"`                  |
| `getLocaleWeekDay()`           | Localized weekday number.            | `"१"`                   |
| `getLocaleWeekDayName()`       | Localized weekday name.              | `"आइतबार"`              |
| `getLocaleShortWeekDayName()`  | Localized short weekday name.        | `"आइत"`                 |
| `getLocaleDay()`               | Localized day.                       | `"१२"`                  |
| `getLocaleTwoDigitDay()`       | Localized two-digit day.             | `"१२"`                  |
| `getLocaleHour()`              | Localized 24-hour format.            | `"१४"`                  |
| `getLocaleShortHour()`         | Localized 12-hour format.            | `"२"`                   |
| `getLocaleTwoDigitShortHour()` | Localized two-digit 12-hour.         | `"०२"`                  |
| `getLocaleTwoDigitHour()`      | Localized two-digit 24-hour.         | `"१४"`                  |
| `getLocaleMinute()`            | Localized minute.                    | `"४५"`                  |
| `getLocaleTwoDigitMinute()`    | Localized two-digit minute.          | `"४५"`                  |
| `getLocaleSecond()`            | Localized second.                    | `"९"`                   |
| `getLocaleTwoDigitSecond()`    | Localized two-digit second.          | `"०९"`                  |
| `getLocaleMaridian()`          | Localized AM/PM (currently English). | `"PM"`                  |

#### Shorthand & Property Access

For any getter method, you can:

- Drop the get and lowercase the next letter
  → `getLocaleYear()` → `localeYear()`
- Access as property
  → `localeYear`
  **Usage:**
  ```php
   date.getLocaleYear()   // "२०८२" //for nepali locale
   date.localeYear()      // same result
   date.localeYear        // same result
  ```

**Example:**

```php

```

---

## ⚙️ Setters

### 🔹 Basic Setters

| Method                                          | Description                                              |
| :---------------------------------------------- | :------------------------------------------------------- |
| `setYear(int $year)`                            | Sets the BS year.                                        |
| `setMonth(int $month)`                          | Sets the BS month (1–12).                                |
| `setDay(int $day)`                              | Sets the BS day of the month.                            |
| `setHour(int $hour)`                            | Sets the hour (0–23).                                    |
| `setMinute(int $minute)`                        | Sets the minute (0–59).                                  |
| `setSecond(int $second)`                        | Sets the second (0–59).                                  |
| `setTimeZone(int\|DateTimeZone\|string $value)` | Sets the time zone (aliases: `timeZone`, `tZone`, `tZ`). |

---

### 🔹 Unit-Based Setter

| Method                                      | Description                                                                            |
| :------------------------------------------ | :------------------------------------------------------------------------------------- |
| `setUnit(string\|NepaliUnit $unit, $value)` | Sets a specific unit (`year`, `month`, `day`, `hour`, `minute`, `second`, `timezone`). |

---

### 🔹 Combined Setters

| Method                                         | Description                             |
| :--------------------------------------------- | :-------------------------------------- |
| `setDate(int $year, int $month, int $day)`     | Sets year, month, and day together.     |
| `setTime(int $hour, int $minute, int $second)` | Sets hour, minute, and second together. |

---

#### Shorthand & Property Assignment

You can also use setter variants in two shorter forms, similar to getters:

1. Without `set` (camelCase):

   ```php
   $nepalidate.year(2081);
   ```

1. As property assignment (Only Support for mutable instance).

   ```php
   $nepalidate.year = 2081;
   ```

**Example:**

```php

```

---

## Shifting

The `NepaliDate` provides methods to shift dates to their corresponding values based on different contexts like timezone or week.

### TimeZone

```php
use RohanAdhikari\NepaliDate\NepaliDate;

    // current timezone: Asia/Kathmandu
    $nepaliDate = NepaliDate::now();
    echo $nepaliDate->format(NepaliDate::FORMAT_ISO_8601);
    //Exmaple Output: 2082-07-01T11:41:22+05:45

    //shift timezone to Autralia
    $nepaliDate->shiftTimezone('Australia/Melbourne');
    echo $nepaliDate->format(NepaliDate::FORMAT_ISO_8601);
    //Example Output: 2082-07-01T16:56:22+11:00
```

---

### Week

```php
use RohanAdhikari\NepaliDate\NepaliDate;

 $nepaliDate = NepaliDate::parse('2082-07-02');
    // shift to previous monday
    $nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday, false);
    echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
    // shift to next monday
    $nepaliDate->shiftToNearWeek(NepaliDate::MONDAY);
    //or
    $nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday);
    echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);

```

---

## 📏 Boundaries Methods

Boundary methods are used to snap a date/time to the start or end of a defined unit. This is extremely useful for:

- Rounding dates to the beginning or end of a day, week, month, or year.

- Performing date calculations for calendars.

- Filtering datasets by time ranges.

### Available Methods

| Method                  | Description                                                                                |
| ----------------------- | ------------------------------------------------------------------------------------------ |
| startOfDay()            | Sets the time to the very beginning of the day (00:00:00).                                 |
| endOfDay()              | Sets the time to the very end of the day (23:59:59).                                       |
| startOfWeek($weekStart) | Moves the date to the first day of the week (Sunday by default, customizable).             |
| endOfWeek($weekEnd)     | Moves the date to the last day of the week (Saturday by default, customizable).            |
| startOfMonth()          | Moves the date to the first day of the month at 00:00:00.                                  |
| endOfMonth()            | Moves the date to the last day of the month at 23:59:59.                                   |
| startOfQuarter()        | Moves the date to the first day of the current quarter at 00:00:00.                        |
| endOfQuarter()          | Moves the date to the last day of the current quarter at 23:59:59.                         |
| startOfYear()           | Moves the date to the first day of the year at 00:00:00.                                   |
| endOfYear()             | Moves the date to the last day of the year at 23:59:59.                                    |
| startOfDecade()         | Moves the date to the first year of the decade at 00:00:00.                                |
| endOfDecade()           | Moves the date to the last year of the decade at 23:59:59.                                 |
| startOfCentury()        | Moves the date to the first year of the century at 00:00:00.                               |
| endOfCentury()          | Moves the date to the last year of the century at 23:59:59.                                |
| startOfMillennium()     | Moves the date to the first year of the millennium at 00:00:00.                            |
| endOfMillennium()       | Moves the date to the last year of the millennium at 23:59:59.                             |
| startOfHour()           | Sets minutes and seconds to 00:00 of the current hour.                                     |
| endOfHour()             | Sets minutes and seconds to 59:59 of the current hour.                                     |
| startOfMinute()         | Sets seconds to 00 of the current minute.                                                  |
| endOfMinute()           | Sets seconds to 59 of the current minute.                                                  |
| startOf(unit)           | Generic method to snap the date to the start of a specified unit (day, month, year, etc.). |
| endOf(unit)             | Generic method to snap the date to the end of a specified unit (day, month, year, etc.).   |

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDateImmutable::now();
// end of century
echo $nepaliDate->endOfCentury(); // auto convert to string using FORMAT_DATETIME_24_FULL
// Example Output: 2100-12-31 23:59:59

// start of decade
echo $nepaliDate->startOfDecade()->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
// Example Output: 2080/01/01

//start of quarter
echo $nepaliDate->startOf(NepaliUnit::Quarter)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
    // Example Output: 2082-07-01 00:00:00

//end of week
echo $nepaliDate->endOf(NepaliUnit::Week)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example Output: 2082-07-01 23:59:59
```

---

## 🔎 Comparison

The `NepaliDate` class provides a comprehensive set of **comparison and state-checking methods**.  
These methods allow you to compare dates, check if a date falls within a range, or determine its temporal state (past, future, today, etc.).  
All methods accept either another `NepaliDateInterface` instance or a date string that can be parsed into a Nepali date.

| Method                                   | Alias / Shortcut                           | Description                                                                     |
| ---------------------------------------- | ------------------------------------------ | ------------------------------------------------------------------------------- |
| `equalTo($date)`                         | `eq($date)`                                | Returns `true` if the current date is equal to the given date.                  |
| `notEqualTo($date)`                      | `ne($date)`                                | Returns `true` if the current date is not equal to the given date.              |
| `greaterThan($date)`                     | `gt($date)`, `isAfter($date)`              | Returns `true` if the current date is after the given date.                     |
| `greaterThanOrEqualTo($date)`            | `gte($date)`                               | Returns `true` if the current date is after or equal to the given date.         |
| `lessThan($date)`                        | `lt($date)`, `isBefore($date)`             | Returns `true` if the current date is before the given date.                    |
| `lessThanOrEqualTo($date)`               | `lte($date)`                               | Returns `true` if the current date is before or equal to the given date.        |
| `between($date1, $date2, $equal = true)` | `isBetween($date1, $date2, $equal = true)` | Returns `true` if the current date is between two dates (inclusive by default). |
| `betweenIncluded($date1, $date2)`        | —                                          | Returns `true` if the current date is between two dates, inclusive.             |
| `betweenExcluded($date1, $date2)`        | —                                          | Returns `true` if the current date is between two dates, exclusive.             |
| `isWeekday()`                            | —                                          | Returns `true` if the current date is a weekday (not Saturday).                 |
| `isWeekend()`                            | —                                          | Returns `true` if the current date is a weekend (Saturday).                     |
| `isYesterday()`                          | —                                          | Returns `true` if the current date represents yesterday.                        |
| `isToday()`                              | —                                          | Returns `true` if the current date represents today.                            |
| `isTomorrow()`                           | —                                          | Returns `true` if the current date represents tomorrow.                         |
| `isFuture()`                             | —                                          | Returns `true` if the current date is in the future.                            |
| `isPast()`                               | —                                          | Returns `true` if the current date is in the past.                              |
| `isNowOrFuture()`                        | —                                          | Returns `true` if the current date is now or in the future.                     |
| `isNowOrPast()`                          | —                                          | Returns `true` if the current date is now or in the past.                       |

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

    //Today Date: 2082-07-01
    $nepaliDate = NepaliDate::parse('2082-07-02'); //WeekDay: Sunday

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

    // Check if the date is tomorrow
    var_dump($nepaliDate->isTomorrow());
    // Output: bool(true)

    // Check if the date is weekday
    var_dump($nepaliDate->isWeekday());
    // Output: bool(true)

    // Check if the date is weekend
    var_dump($nepaliDate->subDays(1)->isWeekend());
    // Output: bool(true)
```

---

## Additional

### Usage in Laravel Example

For detailed instructions on using **NepaliDate** in a Laravel application, see the [Laravel Integration Guide](./docs/LARAVEL.md).

---

### 🌐 Locale Customization

You can customize locale data for months, weekdays, numbers, and more.  
For detailed instructions, see the [LocaleCustomize](./docs/LOCALECUSTOMIZE.md) documentation.

---

### ⚡ Custom Functions / Macros

You can also add your own functions or macros to extend `NepaliDateTime` functionality.  
For detailed instructions, see the [Macro](./docs/MACRO.md) documentation.

---

### NepaliNumbers

You can also use the `NepaliNumbers` class to work with Nepali numerals.
For detailed information, see the [NepaliNumbers](./docs/NEPALINUMBERS.md) documentation.

---

<!-- ### Calendar

You can use the `Calendar` class to work with total days in a year and to get week information.
For detailed information, see the [Calendar](./docs/CALENDER.md) documentation. -->
