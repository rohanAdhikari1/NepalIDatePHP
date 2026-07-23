# Setters

- [Basic Setters](#-basic-setters)
- [Unit-Based Setter](#-unit-based-setter)
- [Combined Setters](#-combined-setters)
- [Shorthand & Property Assignment](#shorthand--property-assignment)

> On `NepaliDate` (mutable), setters modify the instance in place and return `$this`. On `NepaliDateImmutable`, they return a **new** instance and leave the original unchanged.

---

## 🔹 Basic Setters

| Method                                            | Description                                                |
| :--------------------------------------------------| :------------------------------------------------------------ |
| `setYear(int $year)`                               | Sets the BS year.                                            |
| `setMonth(int $month)`                             | Sets the BS month (1–12).                                    |
| `setDay(int $day)`                                 | Sets the BS day of the month.                                 |
| `setHour(int $hour)`                               | Sets the hour (0–23).                                        |
| `setMinute(int $minute)`                           | Sets the minute (0–59).                                       |
| `setSecond(int $second)`                           | Sets the second (0–59).                                       |
| `setTimeZone(int\|DateTimeZone\|string $value)`     | Sets the time zone (aliases: `timeZone`, `tZone`, `tZ`).      |

---

## 🔹 Unit-Based Setter

| Method                                        | Description                                                                             |
| :-----------------------------------------------| :------------------------------------------------------------------------------------------ |
| `setUnit(string\|NepaliUnit $unit, $value)`     | Sets a specific unit (`year`, `month`, `day`, `hour`, `minute`, `second`, `timezone`).      |

---

## 🔹 Combined Setters

| Method                                            | Description                                |
| :---------------------------------------------------| :--------------------------------------------- |
| `setDate(int $year, int $month, int $day)`         | Sets year, month, and day together.            |
| `setTime(int $hour, int $minute, int $second)`     | Sets hour, minute, and second together.        |

---

## Shorthand & Property Assignment

Setters also come in two shorter forms, mirroring the getters:

1. Without `set` (camelCase):

   ```php
   $nepaliDate->year(2081);
   ```

2. As a property assignment (mutable instances only):

   ```php
   $nepaliDate->year = 2081;
   ```

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::now();
$nepaliDate->setDate(2082, 5, 12);
$nepaliDate->year(2083);
$nepaliDate->month = 6;
```

**Next:** [Boundaries →](./BOUNDARIES.md)
