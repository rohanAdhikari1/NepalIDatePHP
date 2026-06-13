<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Laravel\Livewire;

use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

class NepaliDateSynth extends Synth
{
    public static $key = 'nepali_date';

    public static function match($target)
    {
        return $target instanceof NepaliDateInterface;
    }

    public function dehydrate($target)
    {
        return [$target->toArray(), []];
    }

    public function hydrate($value)
    {
        $instance = NepaliDate::fromArray($value);
        return $instance;
    }
}
