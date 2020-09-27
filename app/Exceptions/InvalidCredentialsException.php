<?php

namespace App\Exceptions;

class InvalidCredentialsException extends \Exception
{
    /**
     * User invalid credentials.
     * 
     * @var array
     */
    public $credentials;

    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @return void
     */
    function __construct($message, $credentials)
    {
        $this->credentials = $credentials;

        parent::__construct($message);
    }
}
