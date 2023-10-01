<?php

declare(strict_types=1);

namespace App\Dto\Currency;

class DateRate
{
    public function __construct(
        public float $value,
        public float $differencePreviousDay,
        public \DateTimeInterface $date
    ) {
    }
}
