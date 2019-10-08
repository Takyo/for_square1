<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'coin',
        'rrp',
    ];

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

    public function images()
    {
        return $this->belongsToMany('App\Image')->withPivot('filepath');
        // return $this->belongsToMany('Images::class');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Property', 'product_property', 'product_id', 'property_id')->withPivot('content');
        // return $this->belongsToMany('App\Property', 'product_property', '', 'product_id');
        // return $this->belongsToMany('App\Property', 'product_property');
        // return $this->belongsToMany('App\Property');
    }
}
