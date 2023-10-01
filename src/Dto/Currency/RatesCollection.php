<?php

declare(strict_types=1);

namespace App\Dto\Currency;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlRoot;

#[XmlRoot(name: 'ValCurs')]
class RatesCollection
{
    /** @var CurrencyRate[] */
    #[Type('array<App\Dto\Currency\CurrencyRate>')]
    #[XmlList(inline: true, entry: 'Valute')]
    #[SerializedName('Valute')]
    public array $rates;
}
