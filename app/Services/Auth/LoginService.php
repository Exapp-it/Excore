<?php

namespace Excore\App\Services\Auth;

use Excore\App\Models\User;
use Excore\Core\Helpers\Date;
use Excore\Core\Helpers\Hash;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\Validation\Validator;

class LoginService
{

    protected array $errors = [];
    protected ?string $message = null;
    protected ?User $user = null;

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Session $session,
    ) {
        $this->userInit();
    }

    public function auth()
    {
        $authToken = $this->generateAuthToken();
        $this->user->update(['auth_token' => $authToken]);
        auth()->store($this->user);
    }

    public function validate()
    {
        $validator =  Validator::init($this->request->post());
        $validator->rules([
            'login' => ['required', 'login'],
            'password' => ['required'],
        ])->validate();

        if (!$validator->isValid()) {
            $this->message = "Ошибка валидации";
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function userVerify()
    {
        if (!$this->user) {
            $this->message = 'Пользователь не найден';
            return false;
        }

        if (!Hash::passwordVerify($this->request->input('password'), $this->user->password)) {
            $this->message = 'Пользователь не найден';
            return false;
        }

        return true;
    }

    public function success()
    {
        return $this->response->sendJson([
            'success' => true,
            'message' =>  $this->message,
            'redirect' => '/dashboard',
        ]);
    }

    public function fail()
    {
        return $this->response->sendJson([
            'success' => false,
            'message' => $this->message,
            'errors' => $this->errors,
        ]);
    }

    private function userInit()
    {
        $this->user = (new User())->getByLogin($this->request->input('login'));
    }

    private function generateAuthToken()
    {
        return Hash::generateToken($this->user->id);
    }
}
