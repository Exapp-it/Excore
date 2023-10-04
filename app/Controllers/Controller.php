<?php

namespace Excore\App\Controllers;

use Excore\Core\Core\BaseController;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\View\View;

class Controller extends BaseController
{

    public function __construct(Request $request, View $view)
    {
        $this->request = $request;
        $this->view = $view;
    }
}
