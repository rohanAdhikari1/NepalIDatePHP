## Customizing Locale Data

You can customize locale `Months`, `ShortMonths`, `WeekDays`, and `ShortWeekDays` for `NepaliDateTime`.
Available locales are `en` and `np`.

You can reference locales using constants:

```php
NepaliDate::NEPALI
//--or--
NepaliDateImmutable::ENGLISH,
//--or--
NepaliDateInterface::ENGLISH,
```

---

### Available Methods

#### `NepaliDateTime::customizeLocaleMonths(string $locale,array $months)`

Customize full month names for locale en or np .

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDateTime::customizeLocaleMonths(NepaliDate::NEPALI,[
    "बैशाख", "जेठ", "असार", "साउन", "भदौ", "आश्विन",
    "कार्तिक", "मंसिर", "पौष", "माघ", "फाल्गुन", "चैत"
]);
```

#### `NepaliDateTime::customizeLocaleShortMonths(string $locale,array $months)`

Customize short month names for locale.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDateTime::customizeLocaleShortMonths(NepaliDate::NEPALI,[
    "बै", "जे", "अ", "सा", "भ", "आ", "का", "मं", "पौ", "मा", "फा", "च"
]);
```

#### `NepaliDateTime::customizeLocaleWeekDays(string $locale,array $months)`

Customize weekdays names for locale.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDateTime::customizeLocaleWeekDays(NepaliDate::NEPALI,[
    "बै", "जे", "अ", "सा", "भ", "आ", "का", "मं", "पौ", "मा", "फा", "च"
]);
```

#### `NepaliDateTime::customizeLocaleWeekDays(string $locale,array $months)`

Customize weekdays names for locale.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDateTime::customizeLocaleWeekDays(NepaliDate::NEPALI,[
   "आइतबार", "सोमबार", "मङ्गलबार", "बुधबार",
        "बिहिबार", "शुक्रबार", "शनिबार"
]);
```

#### `NepaliDateTime::customizeLocaleShortWeekDays(string $locale,array $months)`

Customize short weekdays names for locale.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDateTime::customizeLocaleShortWeekDays(NepaliDate::NEPALI,[
   "आइ", "सो", "मङ्ग", "बु", "बि", "शु", "श"
]);
```

---

### Customizing All Locale Data at Once

You can also customize multiple or all locale fields together by passing an associative array to `customizeocale` function.

`NepaliDateTime::customizeocale(string $locale,array $data)`

```php
use RohanAdhikari\NepaliDate\NepaliDate;
NepaliDate::customizeocale(NepaliDate::NEPALI,[
    'months' => [
        "बैशाख", "जेठ", "असार", "साउन", "भदौ", "आश्विन",
        "कार्तिक", "मंसिर", "पौष", "माघ", "फाल्गुन", "चैत"
    ],
    'shortmonths' => [
        "बै", "जे", "अ", "सा", "भ", "आ", "का", "मं", "पौ", "मा", "फा", "च"
    ],
    'weekdays' => [
        "आइतबार", "सोमबार", "मङ्गलबार", "बुधबार",
        "बिहिबार", "शुक्रबार", "शनिबार"
    ],
    'shortweekdays' => [
        "आइ", "सो", "मङ्ग", "बु", "बि", "शु", "श"
    ]
]);
```
