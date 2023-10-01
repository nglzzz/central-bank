<?php

declare(strict_types=1);

namespace App\Transformer\Currency;

use App\Dto\Currency\RatesCollection;
use App\Exception\XmlTransformException;
use App\Transformer\XmlTransformerInterface;
use JMS\Serializer\SerializerInterface;

final class RateTransformer implements XmlTransformerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function transform(string $content): RatesCollection
    {
        try {
            return $this->serializer->deserialize($content, RatesCollection::class, 'xml');
        } catch (\Exception $e) {
            throw new XmlTransformException(\sprintf(
                'Error while deserializing XML content: %s',
                $e->getMessage(),
            ));
        }
    }
}
