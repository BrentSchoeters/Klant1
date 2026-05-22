<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothingSize extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function clothing()
    {
        return $this->belongsTo(Clothing::class)->withDefault();
    }

    public function size()
    {
        return $this->belongsTo(Size::class)->withDefault();
    }

    public function clothing_per_people()
    {
        return $this->hasMany(ClothingPerPlayer::class);
    }
}
