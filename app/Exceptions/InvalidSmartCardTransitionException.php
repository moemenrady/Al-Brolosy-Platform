<?php

namespace App\Exceptions;

use Exception;

class InvalidSmartCardTransitionException extends Exception
{
    public function __construct(string $from, string $to)
    {
        parent::__construct("Invalid smart card transition from '{$from}' to '{$to}'.");
    }
}
