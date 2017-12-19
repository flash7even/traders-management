<?php

namespace App;

use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $table = 'sells';

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'cart_id',
        'quantity',
        'price'
    ];


    /**
     * A Product belongs to a Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo('App\Product', 'id');
    }


    /**
     * A Cart belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
