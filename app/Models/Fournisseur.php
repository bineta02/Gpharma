<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'adresse',
        'telephone',
        'statut'
    ];

    // Liaison : Un fournisseur peut être lié à plusieurs achats
    public function achats()
    {
        return $this->hasMany(Achat::class, 'id_fournisseur');
    }
}