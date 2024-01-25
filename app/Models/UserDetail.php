<?php


namespace Excore\App\Models;

use Excore\Core\Core\Model;

class UserDetail extends Model
{

    protected string $table = 'users_details';
    public string $primaryKey = 'id';


    public int $user_id;
    public ?string $payeer = null;
    public ?string $card = null;



    public function __construct(array|object $data = [])
    {
        parent::__construct($data);
    }
}
