<?php

namespace RohanAdhikari\NepaliDate\Laravel\Validation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\NepaliDate as RohanAdhikariNepaliDate;
use RohanAdhikari\NepaliDate\NepaliNumbers;

class NepaliDateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = RohanAdhikariNepaliDate::parse($value);
        } catch (\Exception) {
            $fail('The :attribute must be a valid Nepali date.');
            return;
        }

        if (! $date->isValid()) {
            $fail('The :attribute must be a valid Nepali date.');
        }
    }
}
