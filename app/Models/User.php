<?php

namespace Excore\App\Models;

use Exception;
use Excore\Core\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public string $primaryKey = 'id';



    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $auth_token = null;
    public string $updated_at;
    public string $created_at;


    public function __construct(array|object $data = [])
    {
        parent::__construct($data);
    }


    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();;
    }
}
