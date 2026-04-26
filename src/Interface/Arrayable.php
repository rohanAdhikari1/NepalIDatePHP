<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Interface;

interface Arrayable
{
    public function toArray(): array;

    public static function fromArray(array $data): static;
}
