<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothingPerPlayer extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function clothing_size()
    {
        return $this->belongsTo(ClothingSize::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
