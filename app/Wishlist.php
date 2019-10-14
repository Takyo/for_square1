<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id'
    ];


    /**
     * one wishlist belongs to user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * many to many
     * get all products
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
        // return $this->belongsToMany(Product::class);
    }

}
