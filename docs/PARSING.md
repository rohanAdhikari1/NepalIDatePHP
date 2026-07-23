# Parsing

Two ways to build a `NepaliDate` from a string: [`parse()`](#parse) for common/registered patterns, and [`createFromFormat()`](#createfromformat) when you know the exact pattern.

## Parse

`parse()` tries the given string against a list of default (and any custom-registered) format patterns and returns the first match.

**Default format patterns supported for parsing:**

| Format Pattern    |
| ------------------ |
| `Y-m-d`            |
| `Y-n-d`            |
| `Y-m-d H:i:s`      |
| `Y-m-d h:i:s A`    |
| `h:i A`            |
| `h:i:s A`          |
| `H:i`              |
| `H:i:s`            |
| `U`                |
| `c`                |
| `r`                |
| `D, d M Y H:i:s`   |
| `l, F j, Y g:i A`  |

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::parse('2080-06-02');
$nepaliDate = NepaliDate::parse('2080-6-02');
$nepaliDate = NepaliDate::parse('13:12');

// Adding a new custom parse pattern
NepaliDate::addDefaultParserFormat('j F, Y');
NepaliDate::parse('1 Kartik, 2082');

// You can also add multiple custom parse formats at once
NepaliDate::addDefaultParserFormats(['j F, Y', 'j M, Y']);

// Reset back to the built-in defaults
NepaliDate::resetDefaultParserFormats();
```

## CreateFromFormat

`createFromFormat()` parses a string using one specific format you provide — no guessing involved, and no need to register it globally first.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::createFromFormat('j F, Y', '1 Kartik, 2082');
$nepaliDate = NepaliDate::createFromFormat('Y-m-d H:i:s', '2080-07-01 14:30:00');
$nepaliDate = NepaliDate::createFromFormat('h:i A', '02:45 PM');
```

> Both methods throw `NepaliDateFormatException` when the input doesn't match any recognized pattern, and `NepaliDateOutOfBoundsException` when the parsed value is out of the supported calendar range — see [Exceptions](./EXCEPTIONS.md).

**Next:** [Arithmetic & Shifting →](./ARITHMETIC.md)
