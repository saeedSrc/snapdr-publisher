<?php

namespace App\Domain;

class Notification
{
    public function __construct(public string $to, public string $name, public string $message, public string $type)
    {
    }

    public static function getDataDomain(array $data): static
    {
        return new static($data['to'], $data['name'], $data['message'], $data['type']);
    }
}
