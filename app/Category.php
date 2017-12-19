<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

    protected $fillable = [
        'categoryName'
    ];
    
    /**
     * One Category can have many Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function product() {
        return $this->hasMany('App\Product', 'id');
    }

}
