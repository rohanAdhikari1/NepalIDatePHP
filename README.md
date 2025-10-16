# NepaliDate

A PHP package for handling **Nepali Date and Time (Bikram Sambat - BS)** with full support for localization, date manipulation, and formatting. All calculations are based on the **Nepali calendar**, making it perfect for applications targeting Nepali users or systems that operate primarily in BS.

---

## 🚀 Features

- 🕒 Works in **Nepali (BS) date and time**
- 🗓 Simple function to **convert between AD & BS**
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

> [!NOTE]  
>  This package is being developed to provide Nepali Date and Time support (BS), but **many parts of the documentation are still in progress**.  
> Some features may not be fully documented yet.  
> Testing, updates, and additional maintenance will be resumed after a few months.

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

## Parse

## 🌐 Locale

// TODO: document getLocale, setLocale, localeExists, etc.

## ➕ Unit Operations (Add/Subtract)

// TODO: document addDays, addMonths, subYears, etc.

## 🔍 Getters

// TODO: document getYear, getMonth, getDay, etc.

## ⚙️ Setters

// TODO: document setYear, setTime, setUnit, etc.

## 📏 Boundaries Functions

// TODO: document startOfDay, endOfMonth, etc.

## 🔎 Comparison

// TODO: document eq, gt, lt, between, isToday, etc.

---

## Additional

<!-- ## Usage in Laravel Example

For detailed instructions on using **NepaliDate** in a Laravel application, see the [Laravel Integration Guide](./docs/LARAVEL.md). -->

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

<!-- ### Calendar

You can use the `Calendar` class to work with total days in a year and to get week information.
For detailed information, see the [Calendar](./docs/CALENDER.md) documentation. -->
