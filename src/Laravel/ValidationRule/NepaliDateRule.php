<?php

namespace RohanAdhikari\NepaliDate\Laravel\ValidationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use RohanAdhikari\NepaliDate\NepaliDate;

class NepaliDateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = NepaliDate::parse($value);
        } catch (\Exception) {
            $fail('The :attribute must be a valid Nepali date.');

            return;
        }

        if (! $date->isValid()) {
            $fail('The :attribute must be a valid Nepali date.');
        }
    }
}
