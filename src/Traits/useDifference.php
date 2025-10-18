<?php

namespace RohanAdhikari\NepaliDate\Traits;

use DateInterval;
use DateTimeInterface;

trait useDifference
{
    public function diffAsDateInterval(DateTimeInterface|string $date): DateInterval
    {
        return $this->toAd()->diff($this->resolve($date)->toAd());
    }
}
