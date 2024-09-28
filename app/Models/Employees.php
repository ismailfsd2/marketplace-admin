<?php

namespace App\Models;

use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\Designations;
use App\Models\Departments;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
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

    public function designation()
    {
        return $this->hasOne(Designations::class,'id', 'designation_id');
    }

    public function department()
    {
        return $this->hasOne(Departments::class,'id', 'department_id');
    }
}
