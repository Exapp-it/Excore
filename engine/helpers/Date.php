<?php

namespace Excore\Core\Helpers;
use DateTime;
use DateTimeInterface;
use DateTimeZone;



class Date extends DateTime
{
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if ($time instanceof DateTime || $time instanceof DateTimeInterface) {
            parent::__construct($time->format('Y-m-d H:i:s'), $timezone);
        } else {
            parent::__construct($time, $timezone);
        }
    }

    public static function now(DateTimeZone $timezone = null): self
    {
        return new static('now', $timezone);
    }

    public function addYears(int $years): self
    {
        return $this->modify("+$years year");
    }

    public function subYears(int $years): self
    {
        return $this->modify("-$years year");
    }

    public function addMonths(int $months): self
    {
        return $this->modify("+$months month");
    }

    public function subMonths(int $months): self
    {
        return $this->modify("-$months month");
    }

    public function addDays(int $days): self
    {
        return $this->modify("+$days day");
    }

    public function subDays(int $days): self
    {
        return $this->modify("-$days day");
    }

    public function addHours(int $hours): self
    {
        return $this->modify("+$hours hour");
    }

    public function subHours(int $hours): self
    {
        return $this->modify("-$hours hour");
    }

    public function addMinutes(int $minutes): self
    {
        return $this->modify("+$minutes minute");
    }

    public function subMinutes(int $minutes): self
    {
        return $this->modify("-$minutes minute");
    }

    public function addSeconds(int $seconds): self
    {
        return $this->modify("+$seconds second");
    }

    public function subSeconds(int $seconds): self
    {
        return $this->modify("-$seconds second");
    }

    public function toDateString(): string
    {
        return $this->format('Y-m-d');
    }

    public function toTimeString(): string
    {
        return $this->format('H:i:s');
    }

    public function toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }
}
