<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Brands;
use App\Models\Suppliers;

class PointOfContacts extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->hasOne(Brands::class,'id', 'brand_id');
    }

    public function supplier()
    {
        return $this->hasOne(Suppliers::class,'id', 'supplier_id');
    }

    public function created_user()
    {
        return $this->hasOne(User::class,'id', 'created_by');
    }
}
