<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\CustomProduct;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    use HasFactory;

     protected $fillable = [
        'custom_product_id',
        'seller_id',
        'offer',
        'seller_offer_id',
        'seller_descriptions',
        'status',
       
    ];

    public function custom_product()
    {
        return $this->belongsTo(CustomProduct::class);
    }
         public function sellers()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
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
}
