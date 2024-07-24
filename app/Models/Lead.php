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
        'name',
        'lastname',
        'email',
        'country',
        'city',
        'phone',
        'status_id'
    ];
    
    /**
     * Obtiene el estado del lead.
     */
    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }
}