<?php

namespace Excore\App\Controllers\Auth;

use Excore\App\Controllers\Controller;
use Excore\Core\Modules\Validation\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        $this->view->title('Регистрация');
        return $this->view->render('auth/register');
    }

    public function handler()
    {
        $validator =  Validator::init($this->request->post());
        $validator->rules([
            'username' => 'required',
            'email' => 'required', 'email',
            'password' => 'required',
            'passwordConfirm' => 'required',
        ])->validate();

        if ($validator->isValid()) {
            return $this->response->sendJson([
                'message' => "Данные прошли валидацию успешно.",
                'success' => true,
                'redirect' => '/login',
            ]);
        } else {
            return $this->response->sendJson([
                'message' => "Ошибки валидации",
                'errors' => $validator->errors()
            ]);
        }
    }
}
