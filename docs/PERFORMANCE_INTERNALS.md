# Performance Internals

This page is for contributors touching `Calendar.php`, `DateConverter.php`, or `haveDateFormats.php` — it covers what changed in the v2 optimization pass, why, the tooling used to verify it, and what was considered and rejected. If you just want to know how fast the library is or how to use it efficiently in an app, see [Performance](./PERFORMANCE.md) instead.

- [Benchmarking a change](#benchmarking-a-change)
- [Correctness verification](#correctness-verification)
- [What changed in v2](#what-changed-in-v2)
- [Investigated and decided against](#investigated-and-decided-against)

---

## Benchmarking a change

A standalone benchmark script ships in [`check/ConvertPerformanceMeasure.php`](../check/ConvertPerformanceMeasure.php). It has no dependency on the test framework, so you can run it against any branch or commit to compare before/after numbers.

```bash
composer run time:check
# or, with a custom iteration count:
php check/ConvertPerformanceMeasure.php 5000
```

It measures, per operation: total time, time per operation, and peak memory delta, for:

- `NepaliDate::fromAd()` — AD → BS conversion
- `$date->toAd()` — BS → AD conversion
- `$date->format()` — token formatting
- `NepaliDate::now()` — the full "current time" path
- A simulated bulk workload (convert + format N rows), reported as rows/sec

**Run it before and after any change** to `Calendar.php`, `DateConverter.php`, or `haveDateFormats.php` — these are the hot path for every date operation in the library, and a PR touching them should include before/after numbers in the description.

## Correctness verification

Optimizing calendar math is only worth it if the output is still correct. [`check/VerifyConversionRoundTrip.php`](../check/VerifyConversionRoundTrip.php) exhaustively round-trips **every single valid BS date** in the supported range (1900–2100, ~73,400 dates) through `BS → AD → BS` and asserts each one lands back exactly where it started.

```bash
php check/VerifyConversionRoundTrip.php
```

With the year-jump converter it takes a fraction of a second, and the normal suite (`tests/Unit/ConverterEquivalenceTest.php`) now goes further: every AD day from 1843-01-01 to 2044-12-31 is checked in both directions against an independent day-by-day oracle (PHP `DateTime` stepped in lockstep with `NEPALI_DATES`), including the weekday.

[`check/VerifyAgainstLegacyConverter.php`](../check/VerifyAgainstLegacyConverter.php) additionally compares every date against the previous month-walk converter, kept as a test-only reference in `tests/Support/LegacyMonthWalkConverter.php`. It takes ~20 s, so it runs by hand rather than in `composer test`:

```bash
php check/VerifyAgainstLegacyConverter.php
```

**Run the full exhaustive script by hand whenever you touch conversion logic, and always before cutting a release.** It's the reason two pre-existing correctness bugs were caught during the v2 rewrite (see below) — the old day-by-day loop's structure had been masking them, and nothing in the test suite exercised the full supported range until this script existed.

## What changed in v2

Three independent issues were compounding to make bulk conversion slow:

1. **AD ⇄ BS conversion walked from the 1843 / 1900 BS anchor to the target date** — one day at a time in v1 (~66,000 steps for 2025), one month at a time in v2.0-beta (~2,200 steps). It now jumps straight to the year:
   - Both calendars share one **day number** (day 0 = 1 Baisakh 1899 BS, the first year in `NEPALI_DATES`). `Calendar::bsDayNumber()` is a table lookup; `Calendar::adDayNumber()` is the closed-form proleptic-Gregorian day count, shifted so that 1 Baisakh 1900 BS = 1843-04-13 AD.
   - `Calendar::bsDateFromDayNumber()` estimates the BS year, corrects it by at most a step, then scans at most 12 month starts. `Calendar::adDateFromDayNumber()` does the same with Gregorian years.
   - The only table, BS year => month start day numbers (~200 years), is built in one pass on first use (~50 µs).
   - The weekday comes from the same day number (`Calendar::dayOfWeekFromDayNumber()`), so it is also correct for the BS 1899 dates produced by AD dates before 1843-04-13, which the old per-year totals got wrong.
   - The public helpers `getTotalBSDays()` / `getTotalADDays()` return the same values as before for every supported date.
2. **Per-year day totals were recomputed from scratch on every call** (v1). Superseded by the day-number table above.
3. **`format()` computed the AD equivalent up to six times per call, regardless of the format string.** Building the token → value map as a plain PHP array forces every value to be evaluated eagerly — including a `toAd()` call (a full BS → AD conversion) for `'O'`, `'P'`, `'Z'`, `'U'`, `'c'`, and `'r'` — even for a format string like `'Y-m-d'` that uses none of them. `format()` now only evaluates the tokens actually present in the format string, and memoizes the single `toAd()` call needed across all of them within one `format()` invocation.
4. **Every locale-aware getter re-merged the locale data array, even with no customization.** `getLocaleData()` ran `array_merge($default, $override)` on every call — `format()` alone triggers this indirectly 6–10 times. Since the vast majority of instances never call `customizeLocale()`, `getLocaleDataFor()` now returns the default array directly (no allocation) when there's nothing to merge, and only merges when an override actually exists.

The v2.0-beta month walk also surfaced (and fixed) two small pre-existing correctness bugs the old day-by-day loop's structure had been masking:

- The AD year upper bound accepted by validation (`isvalidAdYear()`) was capped one year too early — it used `START_YEAR_AD + (END_YEAR_BS - START_YEAR_BS)` when it needed `BASE_YEAR_AD + (END_YEAR_BS - START_YEAR_BS)`, rejecting the last ~3.5 months of the supported BS range.
- AD dates in 1843 (the one supported year that starts *before* the internal AD day-counting epoch, `BASE_YEAR_AD = 1844`) round-tripped to the wrong BS date, because the day-counting math had no way to represent "before the epoch" as a negative offset. The shared day number has no epoch inside the supported range, so this case needs no special handling any more.

Both are covered by the exhaustive round-trip test now, so a regression here would fail loudly.

## Investigated and decided against

Two further micro-optimizations were measured and found not worth pursuing:

- **Bypassing `__call` magic dispatch for arithmetic methods** (`addDays()`, `subMonth()`, etc. — none of these are real methods; every call goes through `__call`, a `rtrim`, and up to two `preg_match` regex checks before reaching `modifyUnit()`). Measured overhead: ~0.7 µs/call versus calling `modifyUnit()` directly — real, but three orders of magnitude smaller than the `format()` fix above, and replacing it would mean hand-writing ~24 near-identical wrapper methods for a change nobody would notice in a bulk workload dominated by `format()` calls.
- **Precomputing the BS month-start table at "build time"** (committing it as a literal array) instead of building it on first use. The build costs ~2,400 additions once per process (~50 µs), so shipping a second, derived copy of data that already exists in `NEPALI_DATES` wasn't worth the maintenance burden of keeping two tables in sync.
- **Splitting `NEPALI_DATES` into per-decade chunk files** loaded on demand. Without OPcache, the full table costs ~1 ms to load versus ~0.25 ms for a 20-year chunk, saving under 1 ms once per process — next to ~9 ms for Composer's autoloader alone. With OPcache (any normal FPM / Laravel deployment) the difference disappears. Jumping to a year also needs every earlier year's length, so chunking would still require a committed year-start index kept in sync with the chunks.
- **PHP's `gregoriantojd()` / `jdtogregorian()`.** Equivalent to the closed-form day count, but needs `ext-calendar`, which isn't enabled everywhere (slim Docker images, some Windows builds).

If you're picking up further performance work, start by re-running `check/ConvertPerformanceMeasure.php` rather than assuming — several numbers above (the locale fix in particular) turned out larger than predicted on paper.
