<?php

namespace Excore\App\Controllers\Auth;

use Exception;
use Excore\App\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return $this->view->render('auth/login', ['name' => 'Sam']);
    }
}
