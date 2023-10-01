<?php

declare(strict_types=1);

namespace App\Dto\Currency;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class CurrencyRate
{
    #[Type('integer')]
    #[SerializedName('NumCode')]
    public int $numCode;

    #[Type('string')]
    #[SerializedName('CharCode')]
    public string $charCode;

    #[Type('integer')]
    #[SerializedName('Nominal')]
    public int $nominal;

    #[Type('string')]
    #[SerializedName('Name')]
    public string $name;

    #[Type('string')]
    #[SerializedName('Value')]
    #[Accessor(setter: 'setValue')]
    public float $value;

    #[Type('string')]
    #[SerializedName('VunitRate')]
    #[Accessor(setter: 'setUnitRate')]
    public float $unitRate;

    public function setValue(string $value): void
    {
        $this->value = (float) str_replace(',', '.', $value);
    }

    public function setUnitRate(string $unitRate): void
    {
        $this->unitRate = (float) str_replace(',', '.', $unitRate);
    }
}
