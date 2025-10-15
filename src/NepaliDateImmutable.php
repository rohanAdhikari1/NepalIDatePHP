<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate;

class NepaliDateImmutable extends NepaliDate
{
    public function isImmutable(): bool
    {
        return true;
    }
}
