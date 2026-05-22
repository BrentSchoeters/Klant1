<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function clothing_sizes()
    {
        return $this->hasMany(ClothingSize::class);
    }

    public function scopeSearchSize($query, $search = "%")
    {
        return $query->where('size', 'like', "%{$search}%");
    }
}
