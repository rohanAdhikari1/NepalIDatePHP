# NepaliNumbers

Utilities to convert numbers between English and Nepali formats, including numeric and word representations, formatting, and currency conversion.

## Available Methods

### `convertToNepali(string|int $number): string`

Converts English digits to Nepali digits.

Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::convertToNepali(123); // '१२३'
```

### `convertToEnglish(string|int $number): string`

Converts Nepali digits to English digits.
Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::convertToEnglish('१२३'); // '123'
```

### `getTwoDigitNumber(int|string $number): string`

Pads a number to two digits.
Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::getTwoDigitNumber(5); // '05'
```

### `nepaliNumberFormat(string $num): string`

Formats a number with Nepali grouping (e.g., 1,00,000).
Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::nepaliNumberFormat('1234567'); // '12,34,567'
```

### `getNepaliCurrency(int|string $amount, bool|string $symbol = true, bool $only = false, bool $format = true, string $locale = 'np'): string`

**Parameters:**

- `amount` The numeric amount to format.
- `symbol` If `true`, adds the default currency symbol 'रू'. Can also pass a custom symbol as a string.
- `only` If `true`, adds a postfix: `'मात्र'` for Nepali locale or `'/-'` for English.
- `format` If `true`, formats the number with commas according to Nepali number grouping.
- `locale` The locale to use. 'np' for Nepali, 'en' for English.

Formats a number as currency with optional symbol, formatting, and locale.
Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::getNepaliCurrency(123456); // 'रू १,२३,४५६'
NepaliNumbers::getNepaliCurrency(123456, 'Rs', only:true); // 'Rs १,२३,४५६ मात्र'
NepaliNumbers::getNepaliCurrency(123456, fromat:false); // 'रू १२३४५६'

```

### `getNepaliWord(string $amount, bool $currency = true, string $locale = 'np', bool $only = false): string`

Converts a number to words, including decimal and currency.

**Parameters:**

- `amount` The numeric amount to format.
- `currency` If `true`, adds currency unit words: `'रुपैंया'` for Nepali locale or `'Rupees'` for English.
- `locale` The locale to use. 'np' for Nepali, 'en' for English.
- `only` If `true`, adds a postfix: `'मात्र'` for Nepali locale or `'Only'` for English.

Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
NepaliNumbers::getNepaliWord('1234.56'); // 'एक हजार दुई सय चौंतीस रुपैंया, छपन्न पैसा'

```

### `converter(string $locale = 'en'): callable`

Returns a closure to convert numbers to words in the specified locale (`'np'` or `'en'`).
Example:

```php
use RohanAdhikari\NepaliDate\NepaliNumbers;
$npConverter = NepaliNumbers::converter('np');
$npConverter('45'); // 'पैंतालिस'

```
