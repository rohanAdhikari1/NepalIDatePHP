# Initializing a NepaliDate

Create a new `NepaliDate` (or `NepaliDateImmutable`) instance in whichever way fits your use case. Every constructor below accepts an optional `timezone`, defaulting to `'Asia/Kathmandu'`.

- [now()](#now)
- [Native PHP DateTime](#using-php-native-datetime)
- [Notation strings](#using-datetime-notation)
- [Unix timestamp](#using-unix-timestamp)
- [Direct construction](#direct)

---

## Now

Returns an instance initialized with the **current Nepali date and time**.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_12_FULL); // 2082-06-30 10:09:38 PM

// You can also specify a timezone
$now = NepaliDate::now('Asia/Kathmandu');
// or
$timezone = new DateTimeZone('Asia/Kathmandu');
NepaliDate::now($timezone);
```

---

## Using PHP Native DateTime

Create a `NepaliDate` instance directly from a PHP native `DateTime` (AD). This automatically converts the **Gregorian (AD)** date into the **Nepali (BS)** calendar.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$date = new DateTime();
$nepaliDate = NepaliDate::fromAd($date);
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // 2082-06-30
```

---

## Using DateTime Notation

Create a `NepaliDate` instance using a **natural language date string** (like `'now'`, `'yesterday'`, `'tomorrow'`). This internally parses the notation using native `DateTime` and converts it into the corresponding **Nepali (BS)** date.

- `notation` — A date string supported by PHP's native `DateTime` parser (e.g., `'now'`, `'yesterday'`, `'2025-01-01'`, `'next monday'`).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::fromNotation('tomorrow');
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // e.g. 2082-06-31
```

---

## Using Unix Timestamp

Create a `NepaliDate` instance from a **Unix timestamp**. This first converts the timestamp into a PHP `DateTime` object and then translates it into the equivalent **Nepali (BS)** date and time.

- `timestamp` — A valid Unix timestamp (seconds since Unix epoch).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::fromTimestamp(1760632252);
echo $nepaliDate->format(NepaliDate::FORMAT_DATETIME_24_FULL); // e.g. 2082-06-30 22:15:52
```

---

## Direct

Manually create a new `NepaliDate` instance by providing all date components.

- `year` — Nepali year (e.g. `2082`)
- `month` — Nepali month number (`1–12`)
- `day` — Day of month (`1–32`, varies by **year** and **month**)
- `hour` _(optional)_ — Defaults to `0`
- `minute` _(optional)_ — Defaults to `0`
- `second` _(optional)_ — Defaults to `0`
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = new NepaliDate(2082, 6, 30, timezone: 'Asia/Kathmandu');
```

---

## Immutable Variant

Every method above has an immutable equivalent via `NepaliDateImmutable`, which returns a new instance on every mutation instead of modifying in place.

```php
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

$immutableNow = NepaliDateImmutable::now();
$newDate = $immutableNow->addDays(10); // returns a new instance, original unchanged
```

You can freely convert between the two:

```php
$immutable = $date->toImmutable();
$mutable = $immutable->toMutable();
$either = $date->cast(); // toggles mutable <-> immutable
```

**Next:** [Formatting →](./FORMATTING.md)
