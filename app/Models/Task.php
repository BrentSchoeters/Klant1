<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function task_per_activities()
    {
        return $this->hasMany(TaskPerActivity::class);
    }

    public function scopeSearchTask($query, $search = "%")
    {
        return $query->where('task', 'like', "%{$search}%");
    }
}
