# NepaliDateTime

A PHP Composer package for handling **Nepali Date and Time (Bikram Sambat - BS)** with full support for localization, date manipulation, and formatting. All calculations are based on the **Nepali calendar**, making it perfect for applications targeting Nepali users or systems that operate primarily in BS.

---

## 🚀 Features

- 🕒 Works in **Nepali (BS) date and time**
- 🗓 Simple function to **convert AD → BS**
- 🔁 Support for **mutable** and **immutable** date handling
- ➕ Add or subtract days, months, and years in BS
- 📅 Get current Nepali date and time
- 🌐 Customizable **locale** (Nepali or English)
- 🔢 Format dates in various display styles and many more.

---

## 📦 Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require rohanadhikari/nepali-datetime
```

---

## Usage

Example:

```php
    //mutable
    $now = NepaliDate::now();
    $immutablenow = NepaliDateImmutable::now();
    $date = NepaliDate::fromNotation('tomorrow');
    $date->addDays(5);
    $addate = $date->toAd();
    $formmatted = $date->format(NepaliDate::FORMAT_DATETIME_24_FULL);
    //immutable
    $immutabledate = $date->cast();
    // or
    $immutabledate = $date->toImmutable();
    $newdate = $immutabledate->addDays(10);
```

## Customize Locale Data

You can also customize locale Data.
For detailed instructions, see the [LocaleCustomize](./docs/LOCALECUSTOMIZE.md) documentation.

## Extra / Bonus

### NepaliNumbers

You can also use the `NepaliNumbers` class to work with Nepali numerals.
For detailed information, see the [NepaliNumbers](./docs/NEPALINUMBERS.md) documentation.

<!-- ### Calender

You can use the `Calendar` class to work with total days in a year and to get week information.
For detailed information, see the [Calender](./docs/CALENDER.md) documentation. -->
