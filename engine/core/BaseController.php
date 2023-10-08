<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;

abstract class BaseController
{
    protected Request $request;
    protected Response $response;
    protected Session $session;
    protected View $view;

    public function __construct(Request $request, Response $response, Session $session,  View $view)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->view = $view;
    }
}
