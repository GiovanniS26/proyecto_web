<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by_user_id');
    }
    
    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'members');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class);
    }

    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
}
