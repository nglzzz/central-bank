<?php

declare(strict_types=1);

namespace App\Handler\Currency;

use App\Dto\Currency\CurrencyRate;
use App\Dto\Currency\DateRate;
use App\Service\CurrencyRateService;

final class RateHandler
{
    private const DEFAULT_BASE_CURRENCY = 'RUR';

    public function __construct(
        private readonly CurrencyRateService $currencyRateService,
    ) {
    }

    /**
     * @param \DateTimeImmutable $date
     */
    public function getRate(
        \DateTimeInterface $date,
        string $currency,
        ?string $baseCurrency
    ): ?DateRate {
        if (null === $baseCurrency) {
            $baseCurrency = self::DEFAULT_BASE_CURRENCY;
        }

        $dateBefore = $date->sub(new \DateInterval('P1D'));

        $rateByDate = $this->getRateByDate($date, $currency);
        $rateByDayBefore = $this->getRateByDate($dateBefore, $currency);

        if (null === $rateByDate || null === $rateByDayBefore) {
            return null;
        }

        if (self::DEFAULT_BASE_CURRENCY === $baseCurrency) {
            return new DateRate(
                $rateByDate->value,
                $rateByDate->value - $rateByDayBefore->value,
                $date,
            );
        }

        $baseCurrencyRate = $this->getRateByDate($date, $baseCurrency);
        $baseCurrencyRateDayBefore = $this->getRateByDate($dateBefore, $baseCurrency);

        $value = $rateByDate->value / $baseCurrencyRate->value;
        $valueDayBefore = $rateByDayBefore->value / $baseCurrencyRateDayBefore->value;

        return new DateRate(
            $value,
            $value - $valueDayBefore,
            $date,
        );
    }

    private function getRateByDate(\DateTimeInterface $date, string $currency): ?CurrencyRate
    {
        $collectionByDate = $this->currencyRateService->getByDate($date);

        if (empty($collectionByDate->rates)) {
            return null;
        }

        $rate = null;
        foreach ($collectionByDate->rates as $item) {
            if ($item->charCode === $currency) {
                $rate = $item;
            }
        }

        return $rate;
    }
}
