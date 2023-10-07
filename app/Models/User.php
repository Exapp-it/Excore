<?php

namespace Excore\App\Models;

use Exception;
use Excore\Core\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public string $primaryKey;
    public string $name;
    public string $email;
    public string $password;


}
