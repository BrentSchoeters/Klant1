<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingMatch extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function task_per_activities()
    {
        return $this->hasMany(TaskPerActivity::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function scopeSearchTraining($query, $search = "%")
    {
        return $query->where('date', 'like', "%{$search}%");
    }

    public function scopeSearchWedstrijd($query, $search = "%")
    {
        return $query->where('date', 'like', "%{$search}%");
    }
    public function carpools(){
        return $this->hasMany(Carpool::class);
}
}
