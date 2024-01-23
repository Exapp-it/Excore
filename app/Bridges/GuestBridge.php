<?php

namespace Excore\App\Bridges;

use Excore\Core\Core\Bridge;
use Excore\Core\services\Auth;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;


class GuestBridge extends Bridge
{
    public function handler(Request $request, Response $response, $next = null)
    {
        if (Auth::check()) {
            return $response->redirect('/dashboard');
        }

        return $next;
    }

    public function register()
    {
        //
    }
}
