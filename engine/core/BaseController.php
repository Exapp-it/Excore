<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\View\View;
use Excore\Core\Modules\Http\Request;

class BaseController
{
    protected Request $request;
    protected View $view;

    public function __construct(Request $request, View $view) 
    {
        $this->request = $request;
        $this->view = $view;
    }
}
