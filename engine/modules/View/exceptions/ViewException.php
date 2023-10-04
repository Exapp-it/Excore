<?php

namespace Excore\Core\Modules\View\Exceptions;

use Exception;


class viewException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
