<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Discounts extends Model
{
    use HasFactory;

    public function created_user()
    {
        return $this->hasOne(User::class,'id', 'created_by');
    }
}
