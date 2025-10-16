## Constants

### Days of the Week

| Constant    | Value |
| ----------- | ----- |
| `SUNDAY`    | 1     |
| `MONDAY`    | 2     |
| `TUESDAY`   | 3     |
| `WEDNESDAY` | 4     |
| `THURSDAY`  | 5     |
| `FRIDAY`    | 6     |
| `SATURDAY`  | 7     |

### Nepali Months

| Constant   | Value |
| ---------- | ----- |
| `BAISAKH`  | 1     |
| `JESTHA`   | 2     |
| `ASHAR`    | 3     |
| `SHRAWAN`  | 4     |
| `BHADRA`   | 5     |
| `ASOJ`     | 6     |
| `KARTHIK`  | 7     |
| `MANGHSIR` | 8     |
| `PAUSH`    | 9     |
| `MAGH`     | 10    |
| `FALGUN`   | 11    |
| `CHAITRA`  | 12    |

### Default Locales

| Constant  | Value  |
| --------- | ------ |
| `ENGLISH` | `'en'` |
| `NEPALI`  | `'np'` |

### Common Formats

### Date Formats

| Constant                | Description    | Example      |
| ----------------------- | -------------- | ------------ |
| `FORMAT_DATE_YMD`       | Year-Month-Day | `2082-06-25` |
| `FORMAT_DATE_DMY`       | Day-Month-Year | `25-06-2082` |
| `FORMAT_DATE_MDY`       | Month-Day-Year | `06-25-2082` |
| `FORMAT_DATE_SLASH_YMD` | Year/Month/Day | `2082/06/25` |
| `FORMAT_DATE_SLASH_DMY` | Day/Month/Year | `25/06/2082` |

### Time Formats

| Constant                  | Description         | Example       |
| ------------------------- | ------------------- | ------------- |
| `FORMAT_TIME_24`          | 24-hour             | `23:21`       |
| `FORMAT_TIME_24_WITH_SEC` | 24-hour with second | `23:21:27`    |
| `FORMAT_TIME_12`          | 12-hour with AM/PM  | `11:21 PM`    |
| `FORMAT_TIME_12_WITH_SEC` | 12-hour with second | `11:21:27 PM` |

### DateTime Formats

| Constant                  | Description                         | Example                  |
| ------------------------- | ----------------------------------- | ------------------------ |
| `FORMAT_DATETIME_24`      | Full date-time 24-hour              | `2082-06-25 23:21`       |
| `FORMAT_DATETIME_24_FULL` | Full date-time 24-hour with seconds | `2082-06-25 23:21:27`    |
| `FORMAT_DATETIME_12_FULL` | Full date-time 12-hour              | `2082-06-25 11:21:27 PM` |

### Readable Formats

| Constant                    | Description              | Example                              |
| --------------------------- | ------------------------ | ------------------------------------ |
| `FORMAT_READABLE_DATE`      | Readable Nepali date     | `Saturday, Ashwin 25, 2082`          |
| `FORMAT_READABLE_DATETIME`  | Readable date-time       | `Saturday, Ashwin 25, 2082 11:45 PM` |
| `FORMAT_READABLE_DATETIME2` | Short readable date-time | `Wed, 29 Asw 2082 12:50:05`          |

### ISO, RFC & Timestamps

| Constant                | Description    | Example                           |
| ----------------------- | -------------- | --------------------------------- |
| `FORMAT_ISO_8601`       | ISO-8601       | `2082-06-31T12:00:00+05:45`       |
| `FORMAT_RFC_2822`       | RFC-2822       | `Fri, 31 Asw 2082 12:00:00 +0545` |
| `FORMAT_UNIX_TIMESTAMP` | Unix timestamp | `1760638500`                      |

### File Safe Format

| Constant               | Description | Example               |
| ---------------------- | ----------- | --------------------- |
| `FORMAT_FILENAME_SAFE` | File safe   | `2082-06-25_23-47-44` |

**Example:**

```php
NepaliDate::SUNDAY
//or
NepaliDateImmutable::SUNDAY
//or
NepaliDateInterface::SUNDAY
```
