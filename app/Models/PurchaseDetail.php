<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $primaryKey = "purchase_detail_id";
    protected $guarded = [];
    protected $table = "purchases_details";

    public function product()
    {
        return $this->hasOne(Products::class, 'product_id', 'product_id');
    }
}
