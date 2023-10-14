<?php

namespace Excore\App\Services\Auth;

use Excore\App\Models\User;
use Excore\Core\Helpers\Hash;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\Validation\Validator;

class LoginService
{

    protected array $errors = [];
    protected $user = null;

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Session $session,
    ) {
        $this->userInit();
    }

    public function auth()
    {

    }

    public function validate()
    {
        $validator =  Validator::init($this->request->post());
        $validator->rules([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        if (!$validator->isValid()) {
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function userVerify()
    {
        if (!$this->user) {
            $this->errors = ['text' => 'Пользователь не найден'];
            return false;
        }

        if (!Hash::passwordVerify($this->request->input('password'), $this->user->password)) {
            $this->errors = ['text' => 'Пользователь не найден'];
            return false;
        }

        return true;
    }

    public function success()
    {
        return $this->response->sendJson([
            'message' => "Авторизация прошло успешно.",
            'success' => true,
            'redirect' => '/dashboard',
        ]);
    }

    public function fail()
    {
        return $this->response->sendJson([
            'message' => "Ошибка...",
            'errors' => $this->errors,
        ]);
    }

    private function userInit()
    {
        $this->user = (new User())
            ->where('email', $this->request->input('email'))
            ->first();
    }
}
