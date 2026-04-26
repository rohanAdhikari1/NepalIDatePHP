<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait useArrayable
{
    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'hour' => $this->hour,
            'minute' => $this->minute,
            'second' => $this->second,
            'timezone' => $this->timezone,
            'dayOfWeek' => $this->dayOfWeek,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new static(...array_values($data));
    }
}
