# Performance

If you're converting large batches of Nepali dates — imports, reports, API responses — here's what to expect and how to get the most out of it.

## Results

Measured converting AD ⇄ BS and formatting, before vs. after the v2 optimization pass:

| Operation                          | Before        | After           | Speedup      |
| ---------------------------------- | ------------- | --------------- | ------------ |
| `NepaliDate::fromAd()` (AD → BS)   | ~4,110 µs/op  | ~137 µs/op      | **~30x**     |
| `$date->toAd()` (BS → AD)          | ~7,426 µs/op  | ~202 µs/op      | **~37x**     |
| `$date->format()`                  | ~46,478 µs/op | ~4.3 µs/op      | **~10,800x** |
| Bulk convert + format (throughput) | ~20 rows/sec  | ~7,300 rows/sec | **~365x**    |

Numbers will vary by machine, PHP version, and system load — treat this as "which order of magnitude to expect," not a guaranteed SLA. Benchmark on your own hardware with:

```bash
composer run time:check
```

## Guidance for bulk workloads

- **Prefer format strings without `O`, `P`, `Z`, `U`, `c`, or `r`** when you don't need timezone offset or Unix-timestamp output — these are the only tokens that require an extra internal AD conversion.
- **The first conversion in a batch is marginally slower than the rest** — the library builds a small internal lookup table on first use, once per process/request. Negligible for any batch bigger than a handful of rows.
- **Reuse `NepaliDate` instances** where you can, rather than re-parsing the same date string repeatedly in a loop.
- **In an arithmetic-only hot loop** (no formatting in between), prefer `$date->modifyUnit(NepaliUnit::Day, $n)` over `$date->addDays($n)` — same result, skips a small amount of magic-method dispatch overhead.
- **At the deployment level**, make sure OPcache (`opcache.enable=1`) and, on PHP 8.1+, the JIT are enabled — they matter far more than any remaining code-level detail here.

---

Contributing a change to the conversion code, or curious how the numbers above were achieved? See [Performance Internals](./PERFORMANCE_INTERNALS.md).
