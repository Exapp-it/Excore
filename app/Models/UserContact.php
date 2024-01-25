<?php


namespace Excore\App\Models;

use Excore\Core\Core\Model;

class UserContact extends Model
{

    protected string $table = 'users_contacts';
    public string $primaryKey = 'id';


    public int $user_id;
    public ?string $phone;
    public ?string $vk;
    public ?string $telegram;
    public ?string $instagram;
    public ?string $youtube;



    public function __construct(array|object $data = [])
    {
        parent::__construct($data);
    }
}
