<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
    'nom',
    'prenom',
    'email',
    'adresse',
    'telephone',
    'statut',
    'note' ,
];

    // Optionnel : Une relation pour voir toutes les ventes d'un client plus tard
    public function ventes()
{
    // Un client a plusieurs ventes, et on ordonne par la plus récente
    return $this->hasMany(Vente::class, 'id_client')->latest();
}
}