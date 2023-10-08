<?php

namespace Excore\Core\Core\Exceptions;

use Exception;

class ContainerException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
