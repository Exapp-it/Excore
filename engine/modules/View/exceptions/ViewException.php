<?php

namespace Excore\Core\Modules\View\Exceptions;

use Exception;


class ViewException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
