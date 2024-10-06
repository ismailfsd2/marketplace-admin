<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Categories;
use App\Models\FieldGroups;

class Categories extends Model
{
    use HasFactory;

    public function created_user()
    {
        return $this->hasOne(User::class,'id', 'created_by');
    }

    public function parent()
    {
        return $this->hasOne(Categories::class,'id', 'parent_category');
    }

    public function field_group()
    {
        return $this->hasOne(FieldGroups::class,'id', 'field_group_id');
    }
}
