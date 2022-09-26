<?php

namespace App\Exceptions\HttpException\Abstraction;

use App\Helpers\Helpers;
use RuntimeException;

abstract class HttpException extends RuntimeException
{
    protected string $error;

    public function __construct(int $statusCode, string $message = null)
    {
        $error = Helpers::getClassName($this);
        $this->error = $error;

        parent::__construct($message ?? trans("error.$error"), $statusCode, null);
    }

    public function getError(): string
    {
        return $this->error;
    }
}
