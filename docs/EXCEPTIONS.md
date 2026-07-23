# Exceptions

All exceptions live under `RohanAdhikari\NepaliDate\Exceptions` and extend PHP's built-in `Exception`, so standard `try`/`catch` and framework exception handlers work without any special-casing.

| Exception                          | Thrown When                                                                                   |
| ------------------------------------- | -------------------------------------------------------------------------------------------------- |
| `NepaliDateOutOfBoundsException`      | A year/month/day is outside the supported range (BS `1900`–`2101`) or invalid for its month.       |
| `NepaliDateFormatException`           | `parse()` or `createFromFormat()` can't match the input string against the given/known patterns.  |
| `NepaliDateUnknownUnitException`      | An unrecognized unit string is passed to `setUnit()`, `modifyUnit()`, `startOf()`/`endOf()`, etc.  |
| `InvalidNepaliDateLocale`             | An unregistered locale is passed to `setLocale()`, `defaultLocale()`, or the locale customization methods. |
| `NepaliDateExceptions`                | Generic base case for library errors that don't fit a more specific exception above.               |

## Example

```php
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\Exceptions\NepaliDateOutOfBoundsException;
use RohanAdhikari\NepaliDate\Exceptions\NepaliDateFormatException;

try {
    $date = NepaliDate::createFromFormat('Y-m-d', '2082-13-40');
} catch (NepaliDateOutOfBoundsException $e) {
    // Month 13 / day 40 don't exist
} catch (NepaliDateFormatException $e) {
    // Input didn't match the 'Y-m-d' pattern at all
}
```

> Prefer checking validity ahead of time when you control the input? Use `isValid()` on an already-constructed instance, or the static `NepaliDate::isValidBsDate($year, $month, $day)` / `NepaliDate::isValidAdDate($year, $month, $day)` helpers instead of catching exceptions for control flow.
