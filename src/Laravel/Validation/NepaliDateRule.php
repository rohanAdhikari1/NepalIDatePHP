<?php

namespace RohanAdhikari\NepaliDate\Laravel\Validation;

use Closure;
use RohanAdhikari\NepaliDate\NepaliDate;

class NepaliDateRule implements \Illuminate\Contracts\Validation\ValidationRule
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
