<?php

namespace App\model;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CustomProduct extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
        'seller_id',
        'category_id',
        'addee_by',
        'color',
        'offers',
        'quantity',
        'discount',
        'thumbnail',
        'name',
        'images',
         'video',
        'description',
        'unit',
    ];
    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }
    
     public function reviews()
    {
        return $this->hasMany(Review::class,'custom_product_id');
    }
    public function rating()
    {
        return $this->hasMany(Review::class)
            ->select(DB::raw('avg(rating) average, custom_product_id'))
            ->groupBy('custom_product_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    } 
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
     public function offers()
    {
        return $this->hasOne(Offer::class, 'custom_product_id','seller_id');
    } 
    
}
