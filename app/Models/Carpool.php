<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpool extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function carpool_people()
    {
        return $this->hasMany(CarpoolPerson::class);
    }

    public function match(){
        return $this->belongsTo(TrainingMatch::class)->withDefault();
    }

    public function scopeSearchCarpool($query, $search = "%")
    {
        return $query->where('address', 'like', "%{$search}%");
    }
}
