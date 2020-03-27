<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp extends Model
{
    protected $table = 'bs_mps';

    public function client()
    {
        return $this->belongsTo('App\Models\Client','cid');
    }
}
