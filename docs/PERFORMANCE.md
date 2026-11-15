# Performance

## Speed

| Operation                        | Time per call     |
| -------------------------------- | ----------------- |
| `NepaliDate::fromAd()` (AD → BS) | ~2.3 µs           |
| `$date->toAd()` (BS → AD)        | ~1.8 µs           |
| `$date->format()`                | ~4.1 µs           |
| Bulk convert + format            | ~150,000 rows/sec |

The calendar math itself takes well under a microsecond; the rest is PHP's `DateTime` and object creation. Numbers vary by machine. Measure your own with:

```bash
composer run time:check
```

## How conversion is fast

Every conversion takes the same small amount of work, whatever the date. Nothing counts forward from 1900 BS / 1843 AD.

### 1. One shared day number

Both calendars are placed on one day count: day 0 is 1 Baisakh 1899 BS, and 1 Baisakh 1900 BS = 13 April 1843 AD is day 366. If two dates have the same day number, they are the same day. So a conversion is:

```
date → day number → date in the other calendar
```

### 2. Prefix sums: date → day number

**BS.** Month lengths come from `NEPALI_DATES`. On the first conversion, the library adds them up once into a prefix-sum table: the day number on which every month starts.

```
2082: [66842, 66873, 66904, 66936, 66967, 66998, 67029, 67059, 67088, 67118, 67147, 67177, 67207]
        Bai    Jes    Asa    Shr    Bha    Asw    Kar    Man    Pou    Mag    Fal    Cha   next year
```

A BS date's day number is one lookup: `start of the month + day − 1`. For example, 29 Kartik 2082 → `67029 + 28 = 67057`.

The table covers about 200 years, takes a few KB, and is built once per process in ~50 µs.

**AD.** Gregorian leap years follow a fixed rule, so the same prefix sum is a formula and needs no table:

```
days before year Y = 365·(Y−1) + ⌊(Y−1)/4⌋ − ⌊(Y−1)/100⌋ + ⌊(Y−1)/400⌋
```

Add the days before the month and the day, then a fixed offset that lines it up with the BS count. For example, 15 Nov 2025 → day 67057.

### 3. Estimate the year, then correct it: day number → date

**Estimate.** Day numbers grow at an almost steady rate, so dividing gives the year directly:

- **BS:** `1899 + ⌊n / 366⌋`. For 67057 that gives 2082.
- **AD:** `⌊days × 400 / 146097⌋ + 1`, where 146,097 is the number of days in 400 Gregorian years. That gives 2025.

**Correct.** Compare the day number with the start of the estimated year and of the next one. If it falls before the start, step back a year; if it reaches the next year's start, step forward. The estimate is at most a step or two off, so this is one or two comparisons.

**Month and day.** Scan that year's month starts (at most 12 comparisons) for the last one that is ≤ the day number. Then subtract to get the day:

```
67029 (Kartik) ≤ 67057 < 67059 (Mangsir)  →  month 7, day 67057 − 67029 + 1 = 29
```

### 4. Weekday

Weekdays repeat every 7 days, so the weekday comes from the same day number. 1 Baisakh 1900 (day 366) was a Thursday, and `day number mod 7` gives the rest.

### Why the result is exact

The year estimate only chooses where to start looking. The comparisons against real year and month starts decide the answer, so a bad estimate would cost an extra step, never a wrong date. Everything is whole-number arithmetic. BS dates are exactly as correct as the month lengths in `NEPALI_DATES`.
