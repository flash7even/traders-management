<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposit';

    protected $fillable = [
        'id',
        'user_id',
        'deposit_amount'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
