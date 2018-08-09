<?php

namespace VestaAPI\Exceptions;

use Exception;

class VestaExceptions extends Exception
{
    public function __construct($code)
    {
        $response_codes = require 'response_codes.php';
        parent::__construct($response_codes[$code]['comment']);
    }
}
