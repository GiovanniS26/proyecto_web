<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by_user_id',
        'user_id',
        'subject',
        'status',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

