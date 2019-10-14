<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * many to many
     * get all products
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_property', 'property_id', 'product_id')->withPivot('content');
        // return $this->belongsToMany('App\Product', 'product_property');
        // return $this->belongsToMany('App\Product');
    }
}
