<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

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
        return $this->belongsToMany('App\Product')->withPivot('filepath');
        // return $this->belongsToMany('Product::class');
    }
}
