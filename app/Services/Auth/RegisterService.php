<?php

namespace Excore\App\Services\Auth;

use Excore\App\Models\User;
use Excore\Core\Helpers\Date;
use Excore\Core\Helpers\Hash;
use Excore\App\Models\UserDetail;
use Excore\App\Models\UserWallet;
use Excore\App\Models\UserContact;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\Validation\Validator;

class RegisterService
{

    protected array $errors = [];
    protected ?string $message = null;
    protected ?User $user = null;

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Session $session,
    ) {
    }

    public function store()
    {
        $user = new User();
        $newUser = $user->create([
            'login' => $this->request->input('login'),
            'email' => $this->request->input('email'),
            'referrer' => null,
            'password' => Hash::passwordHash($this->request->input('password')),
            'created' => Date::now()->toString(),
        ]);
        $this->userInit($newUser);
        $this->createWallet();
        $this->createDetails();
        $this->createConatcts();
    }

    public function validate()
    {
        $validator =  Validator::init($this->request->post());
        $validator->rules([
            'login' => ['required', 'login'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password_confirm' => ['required', 'confirmed:password'],
        ])->validate();


        if (!$validator->isValid()) {
            $this->message = "Ошибка валидации";
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function userExists()
    {
        $user = new User();
        $userExists =  $user->where('login', $this->request->input('login'))
            ->orWhere('email', $this->request->input('email'))
            ->first();


        if ($userExists) {
            $this->message = 'Пользователь с такими данными уже существует';
            return true;
        }

        return false;
    }

    public function success()
    {
        return $this->response->sendJson([
            'success' => true,
            'message' =>  $this->message,
            'redirect' => '/login',
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

    private function userInit(User $user)
    {
        $this->user = $user;
    }

    private function generateWalletAccount($prefix = '', $suffix = '', $length = 8)
    {
        $baseValue = time() * 1000;
        $randomDigits = mt_rand(1000, 9999);

        $baseValueString = strval($baseValue);
        $shuffledBaseValueString = str_shuffle($baseValueString);
        $suffix = str_shuffle($suffix);

        $uniqueId = substr(intval($shuffledBaseValueString) + $randomDigits, 0, $length);

        return $prefix . $uniqueId . $suffix;
    }


    private function createWallet()
    {
        $wallet = new UserWallet();
        $wallet->create([
            'user_id' => $this->user->id,
            'account_number' => $this->generateWalletAccount('VP'),
        ]);
    }

    private function createDetails()
    {
        $detail = new UserDetail();
        $detail->create([
            'user_id' => $this->user->id,
        ]);
    }

    private function createConatcts()
    {
        $contact = new UserContact();
        $contact->create([
            'user_id' => $this->user->id,
        ]);
    }
}
