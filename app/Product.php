<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category()
    {
        return $this->belongsTo('App\Category');
        // return $this->belongsTo(Category::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany('App\Wishlist');
        // return $this->belongsToMany('Wishlist::class');
    }
}
