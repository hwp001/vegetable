<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //对应表
    protected $table = 'bs_clients';
    //绑定是否可以批量赋值
    protected $guarded = [];

    //新增用户
    public function addClients($data)
    {
        return self::save($data);
    }
}
