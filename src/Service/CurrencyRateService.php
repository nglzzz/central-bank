<?php

declare(strict_types=1);

namespace App\Service;

use App\Client\CurrencyClientInterface;
use App\Dto\Currency\RatesCollection;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class CurrencyRateService
{
    public function __construct(
        private readonly CurrencyClientInterface $currencyClient,
        private readonly CacheInterface $cache,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getByDate(\DateTimeInterface $date): ?RatesCollection
    {
        $cacheKey = 'currency_rates_'. $date->format('Y-m-d');

        try {
            $collectionByDate = $this->cache->get($cacheKey, fn() => $this->currencyClient->getRatesByDate($date));
        } catch (InvalidArgumentException $e) {
            $this->logger->error(\sprintf('Cannot get currency from cache. Message: %s', $e->getMessage()));

            $collectionByDate = $this->currencyClient->getRatesByDate($date);
        }

        return $collectionByDate;
    }
}
