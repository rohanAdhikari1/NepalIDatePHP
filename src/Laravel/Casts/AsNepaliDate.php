<?php

namespace RohanAdhikari\NepaliDate\Laravel\Casts;

use Illuminate\Database\Eloquent\Model;
use RohanAdhikari\NepaliDate\NepaliDate;

class AsNepaliDate implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes
{
    protected $format = 'c';

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return NepaliDate::createFromFormat($this->format, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return NepaliDate::parse($value)->locale(NepaliDate::ENGLISH)->format($this->format);
    }
}
