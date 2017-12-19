<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_qty',
        'price',
        'cat_id'
    ];

    /**
     * One Product can have one Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category() {
        return $this->hasOne('App\Category', 'id');
    }
    
}
