<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'bs_comment';
    protected $guarded = [];

    public function Client()
    {
        return $this->hasMany(Client::class,'cid');
    }

    public function Goods()
    {
        return $this->hasMany(Comment::class,'gid');
    }
}
