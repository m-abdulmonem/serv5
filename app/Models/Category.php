<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id')->with('children');
    }

    public function Ads()
    {
        return $this->hasMany(Ad::class);
    }
}
