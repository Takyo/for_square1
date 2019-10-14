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

    /*
    public function test()
    {
        $rel = $this->belongsTo('App\Category');
        $var = "hola";
        // dd($rel->find(1)->get());
        return $this->belongsToMany('App\Image')->withPivot('filepath');
    }
    */

    /**
     * one product has one category
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * many to many
     * get all wishlists
     */
    public function wishlists()
    {
        return $this->belongsToMany('App\Wishlist');
    }

    /**
     * many to many
     * get all images
     */
    public function images()
    {
        return $this->belongsToMany('App\Image')->withPivot('filepath');
    }

    /**
     * many to many
     * get all properties
     */
    public function properties()
    {
        return $this->belongsToMany('App\Property', 'product_property', 'product_id', 'property_id')->withPivot('content');
        // return $this->belongsToMany('App\Property', 'product_property', '', 'product_id');
        // return $this->belongsToMany('App\Property', 'product_property');
        // return $this->belongsToMany('App\Property');
    }
}
