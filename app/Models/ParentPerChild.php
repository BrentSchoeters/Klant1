<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentPerChild extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function child()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }
}
