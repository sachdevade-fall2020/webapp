<?php

namespace App\Exceptions;

class BadRequestException extends \Exception
{
    /**
    * @var string
    */
    protected $message;

    /**
    * Create a new exception instance.
    *
    * @return void
    */
    function __construct($message)
    {
        $this->message = $message;
    }
}
