<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    // Autorise tous les champs à être enregistrés
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(VenteDetail::class, 'id_vente');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}