<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\View\View;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;

abstract class BaseController
{
    protected Request $request;
    protected Response $response;
    protected View $view;

    public function __construct(Request $request, Response $response,  View $view)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
    }
}
