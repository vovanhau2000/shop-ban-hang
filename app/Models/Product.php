<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $appends = ['final_price'];

    public function product_type()
    {
        return $this->belongsTo('App\Models\ProductType', 'id_type', 'id');
    }

    public function bill_detail()
    {
        return $this->hasMany('App\Models\BillDetail', 'id_product', 'id');
    }

    /*link tài liệu tham khảo: https://viblo.asia/p/accessors-va-mutators-trong-laravel-55-bJzKmkEEl9N*/
    public function getFinalPriceAttribute()
    {
        if (empty($this->promotion_price) && empty($this->unit_price)) {
            return 0;
        }

        if (!empty($this->promotion_price)) {
            return $this->promotion_price;
        }
        return $this->unit_price;
    }
}
