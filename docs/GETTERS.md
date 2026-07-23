# Getters

Every getter below is available in two extra shorthand forms — see [Shorthand & Property Access](#shorthand--property-access).

- [Year / Era](#-year--era)
- [Time (24-hour)](#-time-24-hour)
- [Day](#-day)
- [Month](#-month)
- [Time (12-hour)](#-time-12-hour)
- [Timezone](#-timezone)
- [Locale-Based](#-locale-based)

---

## 🕰️ Year / Era

| Method              | Description                             | Example            |
| -------------------- | ---------------------------------------- | -------------------- |
| `getMillennium()`    | Returns millennium number.                | `3` → for `2082`     |
| `getCentury()`       | Returns century number.                   | `21`                 |
| `getDecade()`        | Returns decade number.                    | `209`                |
| `getYear()`          | Returns full year.                        | `2082`                |
| `getShortYear()`     | Returns last two digits of the year.      | `"82"`                |

---

## ⏰ Time (24-hour)

| Method                  | Description                      | Example |
| ------------------------ | ---------------------------------- | --------- |
| `getHour()`              | Hour in 24-hour format (0–23).      | `14`      |
| `getTwoDigitHour()`      | Two-digit 24-hour format.           | `"14"`    |
| `getMinute()`            | Minute (0–59).                      | `45`      |
| `getTwoDigitMinute()`    | Two-digit minute string.            | `"45"`    |
| `getSecond()`            | Second (0–59).                      | `9`       |
| `getTwoDigitSecond()`    | Two-digit second string.            | `"09"`    |

---

## 📆 Day

| Method                | Description                              | Example |
| ----------------------- | ------------------------------------------ | --------- |
| `getDay()`              | Day of the month.                          | `12`      |
| `getTwoDigitDay()`      | Two-digit day string.                      | `"12"`    |
| `getWeekDay()`          | Day of week (1 = Sunday → 7 = Saturday).   | `1`       |

---

## 📅 Month

| Method                  | Description                       | Example |
| ------------------------- | ------------------------------------ | --------- |
| `getMonth()`              | Month number (1–12).                | `5`       |
| `getTwoDigitMonth()`      | Two-digit month.                     | `"05"`    |
| `getQuarter()`            | Returns quarter number (1–4).       | `2`       |
| `getDaysInMonth()`        | Total days in the given BS month.   | `32`      |

---

## 🕛 Time (12-hour)

| Method                     | Description                | Example |
| ---------------------------- | ----------------------------- | --------- |
| `getShortHour()`             | Hour in 12-hour format.       | `2`       |
| `getTwoDigitShortHour()`     | Two-digit 12-hour format.     | `"02"`    |
| `getMaridian()`              | Returns `"AM"` or `"PM"`.     | `"PM"`    |

---

## 🌍 Timezone

| Method                | Description                     | Example                            |
| ----------------------- | ---------------------------------- | ------------------------------------- |
| `getTimezone()`         | Returns timezone object.           | `DateTimeZone('Asia/Kathmandu')`     |
| `getTimezoneName()`     | Returns timezone name.             | `"Asia/Kathmandu"`                    |
| `getTZName()`           | Alias for `getTimezoneName()`.     | `"Asia/Kathmandu"`                    |

---

## 🈯 Locale-Based

All of these render using the current instance [locale](../README.md#-locale) — Nepali digits/names when locale is `np`.

| Method                             | Description                            | Example Output (Nepali) |
| ------------------------------------ | ----------------------------------------- | -------------------------- |
| `getLocale()`                        | Current locale.                           | `"np"`                      |
| `getLocaleMillennium()`              | Localized millennium number.              | `"३"`                       |
| `getLocaleCentury()`                 | Localized century number.                 | `"२१"`                      |
| `getLocaleDecade()`                  | Localized decade number.                  | `"२०९"`                     |
| `getLocaleYear()`                    | Localized year.                           | `"२०८२"`                    |
| `getLocaleShortYear()`               | Localized short year.                     | `"८२"`                      |
| `getLocaleQuarter()`                 | Localized quarter number.                 | `"२"`                       |
| `getLocaleMonth()`                   | Localized month number.                   | `"५"`                       |
| `getLocaleTwoDigitMonth()`           | Localized two-digit month.                | `"०५"`                      |
| `getLocaleMonthName()`               | Localized month name.                     | `"बैशाख"`                   |
| `getLocaleShortMonthName()`          | Localized short month name.               | `"बै"`                      |
| `getLocaleWeekDay()`                 | Localized weekday number.                 | `"१"`                       |
| `getLocaleWeekDayName()`             | Localized weekday name.                   | `"आइतबार"`                  |
| `getLocaleShortWeekDayName()`        | Localized short weekday name.             | `"आइत"`                     |
| `getLocaleDay()`                     | Localized day.                            | `"१२"`                      |
| `getLocaleTwoDigitDay()`             | Localized two-digit day.                  | `"१२"`                      |
| `getLocaleHour()`                    | Localized 24-hour format.                 | `"१४"`                      |
| `getLocaleShortHour()`               | Localized 12-hour format.                 | `"२"`                       |
| `getLocaleTwoDigitShortHour()`       | Localized two-digit 12-hour.              | `"०२"`                      |
| `getLocaleTwoDigitHour()`            | Localized two-digit 24-hour.              | `"१४"`                      |
| `getLocaleMinute()`                  | Localized minute.                         | `"४५"`                      |
| `getLocaleTwoDigitMinute()`          | Localized two-digit minute.               | `"४५"`                      |
| `getLocaleSecond()`                  | Localized second.                         | `"९"`                       |
| `getLocaleTwoDigitSecond()`          | Localized two-digit second.               | `"०९"`                      |
| `getLocaleMaridian()`                | Localized AM/PM (currently English).      | `"PM"`                      |

### Shorthand & Property Access

For any getter method, you can:

- Drop the `get` and lowercase the next letter → `getLocaleYear()` becomes `localeYear()`
- Access it as a property → `localeYear`

```php
$date->getLocaleYear();  // "२०८२" (for Nepali locale)
$date->localeYear();     // same result
$date->localeYear;       // same result
```

**Next:** [Setters →](./SETTERS.md)
