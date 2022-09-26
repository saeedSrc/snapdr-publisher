<?php

namespace App\Domain;

class Queue
{
    public const QUEUE = 'notifications';

    public function __construct(private string $queue, private array $message)
    {
    }

    public function serialize(): string
    {
        return json_encode($this->message);
    }

    public function getQueue(): string
    {
        return $this->queue;
    }
}
