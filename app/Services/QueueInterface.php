<?php

namespace App\Services;

use App\Domain\Queue;

interface QueueInterface
{
    public function publish(Queue $queue): void;
}
