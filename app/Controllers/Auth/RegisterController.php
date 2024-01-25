<?php

namespace Excore\App\Controllers\Auth;


use Excore\App\Controllers\Controller;
use Excore\App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    private ?RegisterService $service = null;

    public function index()
    {


        $this->view->title('Регистрация');
        return $this->view->render('auth/register');
    }

    public function store()
    {
        $this->service = new RegisterService($this->request, $this->response, $this->session);
        if (!$this->service->validate()) {
            return $this->service->fail();
        }

        if ($this->service->userExists()) {
            return $this->service->fail();
        }

        $this->service->store();
        return $this->service->success();
    }
}
