<?php

declare(strict_types=1);

namespace App\Factory;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

final class SerializerFactory
{
    public static function create(): SerializerInterface
    {
        $builder = SerializerBuilder::create();

        return $builder->build();
    }
}
