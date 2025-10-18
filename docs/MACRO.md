## Macro

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

    NepaliDate::macro('addTenDay', fn() => $this->addDays(10));
    NepaliDate::macro('jumpToNextSaturday', fn() => $this->shiftToNearWeek(NepaliDate::SATURDAY));
    //Today: 2082-07-01
    $now = NepaliDate::now();
    $mdate = $now->addTenDay();
    echo $mdate; //Output: 2082-07-11 16:09:27
    $mdate2 = $now->jumpToNextSaturday();
    echo $mdate2; //Output: 2082-07-15 16:13:33 -next saturday from day 11 is 15
```
