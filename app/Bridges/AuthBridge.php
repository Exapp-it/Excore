<?php

namespace Excore\App\Bridges;

use Excore\Core\Core\Bridge;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;


class AuthBridge extends Bridge
{
    public function handler(Request $request, Response $response, $next = null)
    {
        $auth = true;
        if ($request->uri() !== 'dashboard') {
            if ($auth) {
                $response->redirect('/dashboard');
            }
        }


        return $next;
    }

    public function register()
    {
        //
    }
}
