<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

trait haveImmutable
{
    public function isImmutable(): bool
    {
        return false;
    }

    public function toImmutable(): NepaliDateImmutable
    {
        return NepaliDateImmutable::fromInstance($this);
    }

    public function toMutable(): NepaliDate
    {
        return NepaliDate::fromInstance($this);
    }

    /**
     * Casts between mutable and immutable versions.
     *
     * @return NepaliDate|NepaliDateImmutable
     */
    public function cast(): NepaliDateInterface
    {
        return $this->isImmutable() ? $this->toMutable() : $this->toImmutable();
    }

    protected function castInstance(): static
    {
        if (! $this->isImmutable()) {
            return $this;
        }

        return clone $this;
    }
}
