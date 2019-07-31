<?php


namespace App\Exceptions;

use Exception;

class FromVerif extends Exception
{
    private $throwMsg;

    public function __construct($message = "")
    {
        $this->throwMsg = $message;
    }

    public function render()
    {
        return response($this->throwMsg, 422);
    }
}