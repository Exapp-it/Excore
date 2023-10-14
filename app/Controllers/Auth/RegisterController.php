<?php

namespace Excore\App\Controllers\Auth;

use Excore\App\Controllers\Controller;
use Excore\App\Models\User;
use Excore\Core\Helpers\Date;
use Excore\Core\Helpers\Hash;
use Excore\Core\Modules\Validation\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        $csrfToken =  hash::generateCsrfToken();


        $this->view->title('Регистрация');
        return $this->view->render('auth/register', ['csrfToken' => $csrfToken]);
    }

    public function handler()
    {
        $validator =  Validator::init($this->request->post());
        $validator->rules([
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'passwordConfirm' => ['required', 'confirmed:password'],
        ])->validate();

        if (!$validator->isValid()) {
            return $this->fail($validator->errors());
        }

        if ($this->userExists()) {
            return $this->fail(['text' => 'Пользователь с такими данными уже существует']);
        }

        $this->store();
        return $this->success();
    }

    private function userExists()
    {
        $userExists = (new User())
            ->where('email', $this->request->input('email'))
            ->orWhere('username', $this->request->input('username'))
            ->first();

        return !is_null($userExists);
    }


    private function store()
    {
        $user = new User();
        $user->create([
            'username' => $this->request->input('username'),
            'email' => $this->request->input('email'),
            'password' => Hash::passwordHash($this->request->input('password')),
            'updated_at' => Date::now()->toString(),
            'created_at' => Date::now()->toString(),
        ]);
    }

    private function success()
    {
        return $this->response->sendJson([
            'message' => "Данные прошли валидацию успешно.",
            'success' => true,
            'redirect' => '/login',
        ]);
    }

    private function fail($errors)
    {
        return $this->response->sendJson([
            'message' => "Ошибка...",
            'errors' => $errors,
        ]);
    }
}
