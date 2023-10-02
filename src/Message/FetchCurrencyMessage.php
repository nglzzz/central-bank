<?php

declare(strict_types=1);

namespace App\Message;

final class FetchCurrencyMessage
{
    public function __construct(readonly private int $days)
    {
    }

    public function getDays(): int
    {
        return $this->days;
    }
}
