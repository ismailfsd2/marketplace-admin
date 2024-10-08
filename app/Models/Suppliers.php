<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\Designations;
use App\Models\Departments;

class Suppliers extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->hasOne(Countries::class,'id', 'country_id');
    }

    public function state()
    {
        return $this->hasOne(States::class,'id', 'state_id');
    }

    public function city()
    {
        return $this->hasOne(Cities::class,'id', 'city_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'supplier_id', 'id');
    }

    public function created_user()
    {
        return $this->hasOne(User::class,'id', 'created_by');
    }
}
