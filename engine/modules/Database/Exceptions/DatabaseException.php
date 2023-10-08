<?php

namespace Excore\Core\Modules\Database\Exceptions;

use Exception;

class DatabaseException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
