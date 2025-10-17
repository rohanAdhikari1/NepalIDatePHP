<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use DateTimeZone;
use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\NepaliUnit;

trait haveDateSetters
{
    protected function setDayOfWeek(): static
    {
        $this->dayOfWeek = Calendar::calculateDayOfWeek($this->year, $this->month, $this->day);

        return $this;
    }

    public function setUnit(string|NepaliUnit $unit, int|DateTimeZone|string $value): static
    {
        $unit = NepaliUnit::toName($unit);
        $instance = $this->castInstance();

        switch ($unit) {
            case 'year':
                static::validateBSYear($value);
                $instance->year = $value;
                break;

            case 'month':
                $instance->month = $this->normalizeOrThrow($value, 12, 'month', fn ($overflow) => $instance->_modifyUnit('year', $overflow));
                break;

            case 'day':
                $daysInMonth = Calendar::getDaysInBSMonth($instance->year, $instance->month);
                $instance->day = $this->normalizeOrThrow($value, $daysInMonth, 'day', fn ($overflow) => $instance->_modifyUnit('month', $overflow));
                break;

            case 'hour':
                $instance->hour = $this->normalizeOrThrow($value, 23, 'hour', fn ($overflow) => $instance->_modifyUnit('day', $overflow), 0);
                break;

            case 'minute':
                $instance->minute = $this->normalizeOrThrow($value, 59, 'minute', fn ($overflow) => $instance->_modifyUnit('hour', $overflow), 0);
                break;

            case 'second':
                $instance->second = $this->normalizeOrThrow($value, 59, 'second', fn ($overflow) => $instance->_modifyUnit('minute', $overflow), 0);
                break;

            case 'timezone':
            case 'timeZone':
            case 'tZone':
            case 'tZ':
                if ($value instanceof DateTimeZone) {
                    $instance->timezone = $value;
                } elseif (is_string($value)) {
                    try {
                        $instance->timezone = new DateTimeZone($value);
                    } catch (\Exception $e) {
                        throw new \InvalidArgumentException("Invalid timezone string '$value'.", 0, $e);
                    }
                } else {
                    throw new \InvalidArgumentException('Timezone must be a DateTimeZone instance or a valid timezone string.');
                }
                break;

            default:
                throw new \InvalidArgumentException("Unknown unit '$unit'.");
        }
        $instance->setDayOfWeek();

        return $instance;
    }

    public function setTime(int $hour, int $minute, int $second): static
    {
        return $this->setUnit('hour', $hour)->setUnit('minute', $minute)->setUnit('second', $second);
    }

    public function setDate(int $year, int $month, int $day): static
    {
        return $this->setUnit('year', $year)->setUnit('month', $month)->setUnit('day', $day);
    }

    protected function handleSetterDynamicCall(string $method, array $arguments): ?static
    {
        if (! preg_match('/^set(Year|Month|Day|Hour|Minute|Second|Timezone|TimeZone|TZ|TZone|Locale)$/', $method, $matches)) {
            return null;
        }
        $unit = strtolower($matches[1]);
        if (! isset($arguments[0])) {
            throw new \InvalidArgumentException("Missing argument for $method");
        }
        $value = $arguments[0];
        if ($unit === 'locale') {
            return $this->setLocale($value);
        }

        return $this->setUnit($unit, $value);
    }

    protected function handleDynamicSet(string $name, mixed $value): mixed
    {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        return $this->handleSetterDynamicCall($method, [$value]);
    }
}
