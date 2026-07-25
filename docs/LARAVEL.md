# Nepali Date in Laravel (NepaliDate Package)

Using a **Nepali date (Bikram Sambat / BS) in Laravel** usually means three things: storing/reading BS dates on Eloquent models, validating BS date input, and displaying BS dates in Blade views. `RohanAdhikari\NepaliDate` covers all three out of the box via a Laravel service provider that's auto-discovered — no manual registration needed. It wires up:

- [Eloquent attribute casting](#eloquent-attribute-casting) between AD/BS storage and `NepaliDate` objects
- A [`toNepaliDate()` macro](#converting-from-carbon) on `Carbon`
- A [validation rule](#validating-nepali-dates) for form requests
- [Blade directives](#blade-directives) for formatting dates and numbers directly in views
- Answers to common questions in the [FAQ](#faq)

On boot, it also sets `NepaliDate`'s default timezone from your `app.timezone` config value.

> For the core API (formatting, arithmetic, comparisons, etc.), see the [main README](../README.md) and the [docs/](.) folder — this page only covers Laravel-specific integration.

---

## Eloquent Attribute Casting

Four casts are available depending on how you store the date and how you want to read it back.

| Cast                | Stored As      | Retrieved As | Use When                                              |
| -------------------- | -------------- | ------------ | ------------------------------------------------------ |
| `ADAsNepaliDate`      | AD (Gregorian) | `NepaliDate` | Storing in a `date`/`datetime` column, reading as BS.   |
| `ADAsNepaliDateTime`  | AD (Gregorian) | `NepaliDate` | Same as above, with full time precision.                |
| `AsNepaliDate`        | BS (Nepali)    | `NepaliDate` | Storing the BS date string itself.                      |
| `AsNepaliDateTime`    | BS (Nepali)    | `NepaliDate` | Same as above, with full time precision.                |

### Storing AD, retrieving as NepaliDate

```php
use RohanAdhikari\NepaliDate\Laravel\Casts\ADAsNepaliDate;

class Post extends Model
{
    protected function casts(): array
    {
        return [
            'published_at' => ADAsNepaliDate::class,
        ];
    }
}
```

### Storing BS (Nepali) directly

> [!WARNING]
> When storing BS dates, avoid `date`/`datetime` column types — use `string`. Native SQL date columns validate against the Gregorian calendar and will reject or mangle BS values.

```php
use RohanAdhikari\NepaliDate\Laravel\Casts\AsNepaliDate;

class Post extends Model
{
    protected function casts(): array
    {
        return [
            'published_date' => AsNepaliDate::class,
        ];
    }
}
```

Both casts accept an optional format passed to `CastsAttributes`, e.g. `AsNepaliDate::class.':Y-m-d'`, which controls how the value is persisted (default `'Y-m-d'` for the date casts, `'c'` for the datetime casts).

**Usage:**

```php
$post = Post::firstOrCreate([
    'published_at'   => NepaliDate::now(),
    'published_date' => '2082-07-08',
], [
    'title' => 'check 1',
    'body'  => 'body1',
]);

$post->published_at;   // NepaliDate instance
$post->published_date; // NepaliDate instance
```

---

## Converting from Carbon

The service provider registers a `toNepaliDate()` macro on `Carbon` so any Carbon instance in your app can be converted in one call:

```php
use Carbon\Carbon;

$carbonDate = Carbon::now();
$nepaliDate = $carbonDate->toNepaliDate(); // NepaliDate instance
echo $carbonDate->toNepaliDate()->format('Y-m-d');
```

---

## Validating Nepali Dates

`NepaliDateRule` implements Laravel's `ValidationRule` contract, so it can be used anywhere Laravel accepts a rule object — form requests, `Validator::make()`, etc. It parses the input with `NepaliDate::parse()` and fails when the value isn't a valid BS date.

```php
use Illuminate\Http\Request;
use RohanAdhikari\NepaliDate\Laravel\ValidationRule\NepaliDateRule;

public function store(Request $request)
{
    $request->validate([
        'published_date' => ['required', new NepaliDateRule],
    ]);
}
```

---

## Blade Directives

Blade directives let you format Nepali dates and numerals directly in views without importing the class in every template. They accept a `NepaliDate`, a `Carbon`/`DateTime` instance, a date string, or `null` (defaults to "now").

### Formatting directives

| Directive                                    | Default Format               | Description                                   |
| --------------------------------------------- | ----------------------------- | ---------------------------------------------- |
| `@nepaliDate($date, $format = null)`          | `FORMAT_DATE_YMD`             | Print `$date` formatted as a Nepali date.       |
| `@nepaliDateTime($date, $format = null)`      | `FORMAT_DATETIME_24_FULL`     | Print `$date` formatted with time included.     |
| `@nepaliNow($format = null)`                  | `FORMAT_DATETIME_24_FULL`     | Print the current Nepali date/time.             |
| `@nepaliNumber($number)`                      | —                              | Print an English number using Nepali numerals.  |
| `@nepaliCurrency($amount, ...)`               | —                              | Print an amount formatted as Nepali currency.   |

```blade
{{-- Model attribute, default format --}}
<p>Published: @nepaliDate($post->published_at)</p>

{{-- Custom format --}}
<p>Published: @nepaliDate($post->published_at, 'l, F j, Y')</p>

{{-- Works with Carbon too --}}
<p>Created: @nepaliDateTime($post->created_at)</p>

{{-- Current date/time, no argument needed --}}
<p>Today is @nepaliNow('l, F j, Y')</p>

{{-- Nepali numerals and currency --}}
<p>Views: @nepaliNumber($post->views)</p>
<p>Price: @nepaliCurrency($product->price)</p>
```

`@nepaliCurrency` forwards its arguments to [`NepaliNumbers::getNepaliCurrency()`](./NEPALINUMBERS.md#getnepalicurrencyintstring-amount-boolstring-symbol--true-bool-only--false-bool-format--true-string-locale--np-string), so `@nepaliCurrency($amount, 'Rs', true)` works as expected.

### Conditional directives

Registered with Laravel's `Blade::if()`, so each one comes with matching `@else...` and `@end...` pairs.

| Directive                                              | True When...                          |
| -------------------------------------------------------- | -------------------------------------- |
| `@nepaliWeekend($date = null)` / `@endnepaliWeekend`      | `$date` falls on Saturday.              |
| `@nepaliToday($date = null)` / `@endnepaliToday`          | `$date` is today (BS).                  |
| `@nepaliFuture($date = null)` / `@endnepaliFuture`        | `$date` is in the future.                |
| `@nepaliPast($date = null)` / `@endnepaliPast`            | `$date` is in the past.                  |

```blade
@nepaliWeekend($event->starts_at)
    <span class="badge">Weekend event</span>
@elsenepaliWeekend
    <span class="badge">Weekday event</span>
@endnepaliWeekend

@nepaliToday($post->published_at)
    <span class="badge">Published today</span>
@endnepaliToday
```

> All directives are registered automatically by the package's service provider — no configuration needed. They live in [`RohanAdhikari\NepaliDate\Laravel\Blade\BladeDirectives`](../src/Laravel/Blade/BladeDirectives.php) if you need to see the underlying implementation.

---

## FAQ

### How do I use Nepali date in Laravel?

Install the package with `composer require rohanadhikari/nepali-date`. Laravel auto-discovers the service provider, so casts, validation rules, and Blade directives are available immediately — no config file, no manual registration. See [Eloquent Attribute Casting](#eloquent-attribute-casting) to store/read BS dates on a model, or [Blade Directives](#blade-directives) to display one in a view with `@nepaliDate($date)`.

### Is there a Laravel package for Nepali (Bikram Sambat) date?

Yes — this package (`rohanadhikari/nepali-date`). It's framework-agnostic at its core (works in plain PHP) but ships dedicated Laravel integration: Eloquent casts (`AsNepaliDate`, `ADAsNepaliDate`), a `ValidationRule`, and Blade directives, all auto-registered via `RohanAdhikari\NepaliDate\Laravel\ServiceProvider`.

### How do I show a Nepali date in a Blade view?

Use the `@nepaliDate` directive: `@nepaliDate($post->published_at, 'l, F j, Y')`. It accepts a `NepaliDate`, a `Carbon`/`DateTime` instance, a date string, or nothing (defaults to now). See [Blade Directives](#blade-directives) for the full list, including `@nepaliNow`, `@nepaliNumber`, and conditionals like `@nepaliWeekend`.

### How do I convert AD to BS (Bikram Sambat) in a Laravel model?

Cast the column with `ADAsNepaliDate::class` (or `ADAsNepaliDateTime::class` for full time precision) — see [Storing AD, retrieving as NepaliDate](#storing-ad-retrieving-as-nepalidate). The attribute is stored as a normal Gregorian date/datetime and automatically converted to a `NepaliDate` object whenever you read it.

### Does this package validate Nepali date form input in Laravel?

Yes, via `NepaliDateRule`, which implements Laravel's `ValidationRule` contract — see [Validating Nepali Dates](#validating-nepali-dates). It fails validation when the input isn't a real, parseable BS date.
