<?php

namespace Excore\App\Models;

use Exception;
use Excore\Core\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public string $primaryKey = 'id';
    public string $username;
    public string $email;
    public string $password;
    public string $updated_at;
    public string $created_at;
}
