<?php


namespace Excore\App\Models;

use Excore\Core\Core\Model;

class UserWallet extends Model
{

    protected string $table = 'users_wallets';
    public string $primaryKey = 'id';


    public int $user_id;
    public $balance;
    public ?string $account_number;
    public  $withdrawal_limit;



    public function __construct(array|object $data = [])
    {
        parent::__construct($data);
    }
}
