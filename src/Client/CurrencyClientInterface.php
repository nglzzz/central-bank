<?php

namespace App\Client;

use App\Dto\Currency\RatesCollection;

interface CurrencyClientInterface
{
    public function getRatesByDate(\DateTimeInterface $date): ?RatesCollection;
}
