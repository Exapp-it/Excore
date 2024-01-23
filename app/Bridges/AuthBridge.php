<?php

namespace Excore\App\Bridges;

use Excore\App\Services\Auth\Auth;
use Excore\Core\Core\Bridge;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;


class AuthBridge extends Bridge
{
    public function handler(Request $request, Response $response, $next = null)
    {
        if (Auth::check()) {
            return $next;
        } else {
            return $response->redirect('/login');
        }
    }

    public function register()
    {
        //
    }
}
