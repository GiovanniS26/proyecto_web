<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Lead extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'subject',
        'status',
        'description',
        'assigned_to_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }
}