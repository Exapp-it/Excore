<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;


abstract class Bridge
{
    abstract public function handler(Request $request, Response $response, $next = null);
}
