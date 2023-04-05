<?php

namespace App\Exceptions;

use Exception;

class AlreadyPublished extends Exception
{
    public static function new(): self
    {
        return new self();
    }
}
