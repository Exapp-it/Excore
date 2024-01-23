<?php

namespace Excore\App\Controllers\Auth;

use Excore\App\Controllers\Controller;
use Excore\App\Services\Auth\LoginService;


class LoginController extends Controller
{

    private ?LoginService $service = null;




    public function index()
    {
        $this->view->title('Авторизация');
        return $this->view->render('auth/login');
    }

    public function handler()
    {
        $this->service = new LoginService($this->request, $this->response, $this->session);

        if (!$this->service->validate()) {
            return $this->service->fail();
        }

        if (!$this->service->userVerify()) {
            return $this->service->fail();
        }

        $this->service->auth();
        return $this->service->success();
    }
}
