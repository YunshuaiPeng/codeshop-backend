<?php

namespace App\Exceptions;

use Exception;

class CartExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('cart already exists');
    }
}
