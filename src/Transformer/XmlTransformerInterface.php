<?php

declare(strict_types=1);

namespace App\Transformer;

interface XmlTransformerInterface
{
    public function transform(string $content): mixed;
}
