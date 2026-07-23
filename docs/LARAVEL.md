# NepaliDate in Laravel

`RohanAdhikari\NepaliDate` ships a Laravel service provider that is auto-discovered — no manual registration needed. It wires up:

- [Eloquent attribute casting](#eloquent-attribute-casting) between AD/BS storage and `NepaliDate` objects
- A [`toNepaliDate()` macro](#converting-from-carbon) on `Carbon`
- A [validation rule](#validating-nepali-dates) for form requests
- [Blade directives](#blade-directives) for formatting dates and numbers directly in views

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
