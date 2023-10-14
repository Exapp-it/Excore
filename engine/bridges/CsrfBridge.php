<?php

namespace Excore\Core\Bridges;

use Excore\Core\Core\Bridge;
use Excore\Core\Helpers\Hash;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;


class CsrfBridge extends Bridge
{

    public function handler(Request $request, Response $response, $next = null)
    {
        if ($request->method() === "POST") {
            $csrfToken = $request->getHeaders(Response::CSRF_HEADER_NAME);
            if (!Hash::verifyCsrfToken($csrfToken)) {
                return $response->sendJson([
                    'success' => false,
                    'info' => "Ошибка сервера...",
                    'messages' => ['csrf' => 'Invalid CSRF Roken'],
                ]);
            }
        }

        return $next;
    }
}
