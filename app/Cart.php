<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'id',
        'user_id',
        'total_amount',
        'due_amount',
        'due_deadline',
        'cart_type'
    ];


    /**
     * A Cart belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
