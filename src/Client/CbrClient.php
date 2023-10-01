<?php

declare(strict_types=1);

namespace App\Client;

use App\Dto\Currency\RatesCollection;
use App\Transformer\XmlTransformerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CbrClient implements CurrencyClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly XmlTransformerInterface $rateTransformer,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getRatesByDate(\DateTimeInterface $date): ?RatesCollection
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('https://www.cbr.ru/scripts/XML_daily.asp?date_req=%s', $date->format('d/m/Y')),
                [
                    'query' => [
                        'date' => $date->format('Y-m-d'),
                    ],
                ]
            );

            $content = $response->getContent();

            return $this->rateTransformer->transform($content);
        } catch (\Exception $e) {
            $this->logger->error(\sprintf(
                'Cannot get rates for date %s. Message: %s',
                $date->format('d/m/Y'),
                $e->getMessage(),
            ), ['exception' => $e]);

            return null;
        }
    }
}
