<?php

namespace Excore\App\Models;

use Excore\Core\Core\Model;

class User extends Model
{
    protected string $table = 'users';
    public string $primaryKey = 'id';



    public string $login;
    public string $email;
    public ?int $referrer = null;
    public string $password;
    public string $auth_token;
    public ?string $reset_token = null;
    public ?string $status = null;
    public $created;


    public function __construct(array|object $data = [])
    {
        parent::__construct($data);
    }


    public function getByLogin($login)
    {
        return $this->where('login', $login)->first();;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'referrer' => $this->referrer,
            'password' => $this->password,
            'auth_token' => $this->auth_token,
            'reset_token' => $this->reset_token,
            'status' => $this->status,
            'created' => $this->created,
        ];
    }
}
