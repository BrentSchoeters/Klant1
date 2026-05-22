<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function clothing_sizes()
    {
        return $this->hasMany(ClothingSize::class);
    }
    public function scopeSearchClothing($query, $search = "%")
    {
        return $query->where('clothing', 'like', "%{$search}%");
    }
}
