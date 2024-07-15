<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by_user_id',
        'title',
        'description',
        'status',
        'start_date',
        'end_date'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'members');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
