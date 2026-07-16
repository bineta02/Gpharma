<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description', 'ip_address'];

    // Relation pour récupérer l'utilisateur qui a fait l'action
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}