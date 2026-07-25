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

It's deliberately kept out of `composer test` (it takes 1–2 minutes), but `tests/Unit/ConversionTest.php` includes a fast, sampled version of the same check (every year boundary, plus a full month-by-month sweep for a spread of years) that runs in under a second as part of the normal suite.

**Run the full exhaustive script by hand whenever you touch conversion logic, and always before cutting a release.** It's the reason two pre-existing correctness bugs were caught during the v2 rewrite (see below) — the old day-by-day loop's structure had been masking them, and nothing in the test suite exercised the full supported range until this script existed.

## What changed in v2

Three independent issues were compounding to make bulk conversion slow:

1. **AD ⇄ BS conversion was O(days), not O(months).** `ADtoBS()`/`BStoAD()` walked forward **one calendar day at a time** from a fixed 1900/1844 epoch to the target date — tens of thousands of loop iterations for a modern date. The fix batches the walk to jump a whole month at a time (`DateConverter::stepForward()`/`stepBackward()`), landing on the same result in a fraction of the iterations. The algorithm is mathematically identical to the original — verified by the exhaustive round-trip check above.
2. **Per-year day totals were recomputed from scratch on every call.** `Calendar::getTotalBSDays()`/`getTotalADDays()` summed every year from the calendar's base year on every single call. They're now backed by a lazily-built, incrementally-extended cache (`Calendar::bsDaysBeforeYear()`/`adDaysBeforeYear()`), so the summation cost is paid once per process, not once per date.
3. **`format()` computed the AD equivalent up to six times per call, regardless of the format string.** Building the token → value map as a plain PHP array forces every value to be evaluated eagerly — including a `toAd()` call (a full BS → AD conversion) for `'O'`, `'P'`, `'Z'`, `'U'`, `'c'`, and `'r'` — even for a format string like `'Y-m-d'` that uses none of them. `format()` now only evaluates the tokens actually present in the format string, and memoizes the single `toAd()` call needed across all of them within one `format()` invocation.
4. **Every locale-aware getter re-merged the locale data array, even with no customization.** `getLocaleData()` ran `array_merge($default, $override)` on every call — `format()` alone triggers this indirectly 6–10 times. Since the vast majority of instances never call `customizeLocale()`, `getLocaleDataFor()` now returns the default array directly (no allocation) when there's nothing to merge, and only merges when an override actually exists.

Fixing #1 also surfaced (and fixed) two small pre-existing correctness bugs the old day-by-day loop's structure had been masking — see `useValidator::isvalidAdYear()` and `Calendar::adDaysBeforeYear()`:

- The AD year upper bound accepted by validation (`isvalidAdYear()`) was capped one year too early — it used `START_YEAR_AD + (END_YEAR_BS - START_YEAR_BS)` when it needed `BASE_YEAR_AD + (END_YEAR_BS - START_YEAR_BS)`, rejecting the last ~3.5 months of the supported BS range.
- AD dates in 1843 (the one supported year that starts *before* the internal AD day-counting epoch, `BASE_YEAR_AD = 1844`) round-tripped to the wrong BS date, because the day-counting math had no way to represent "before the epoch" as a negative offset. Fixed by making `DateConverter`'s walk bidirectional (`stepForward`/`stepBackward`) and giving `adDaysBeforeYear()` an explicit negative case for `START_YEAR_AD`.

Both are covered by the exhaustive round-trip test now, so a regression here would fail loudly.

## Investigated and decided against

Two further micro-optimizations were measured and found not worth pursuing:

- **Bypassing `__call` magic dispatch for arithmetic methods** (`addDays()`, `subMonth()`, etc. — none of these are real methods; every call goes through `__call`, a `rtrim`, and up to two `preg_match` regex checks before reaching `modifyUnit()`). Measured overhead: ~0.7 µs/call versus calling `modifyUnit()` directly — real, but three orders of magnitude smaller than the `format()` fix above, and replacing it would mean hand-writing ~24 near-identical wrapper methods for a change nobody would notice in a bulk workload dominated by `format()` calls.
- **Precomputing the BS cumulative-days table at "build time"** (committing it as a literal array) instead of building it lazily on first use. The lazy build costs ~200 additions once per process — sub-millisecond — so shipping a second, derived copy of data that already exists in `NEPALI_DATES` wasn't worth the maintenance burden of keeping two tables in sync.

If you're picking up further performance work, start by re-running `check/ConvertPerformanceMeasure.php` rather than assuming — several numbers above (the locale fix in particular) turned out larger than predicted on paper.
