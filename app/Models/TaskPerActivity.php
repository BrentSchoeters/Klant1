<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPerActivity extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // Add attributes to be hidden to the $hidden array
    protected $hidden = ['created_at', 'updated_at'];

    public function task()
    {
        return $this->belongsTo(Task::class)->withDefault();
    }

    public function training_match()
    {
        return $this->belongsTo(TrainingMatch::class)->withDefault();
    }

    public function person_per_tasks()
    {
        return $this->hasMany(PersonPerTask::class);
    }
}
