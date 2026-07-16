<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteDetail extends Model
{
    use HasFactory;

    // 1. On indique le nom exact de la table en base de données
    protected $table = 'vente_details';

    // 2. On autorise l'écriture de ces colonnes spécifiques
    protected $fillable = [
        'id_vente',       // L'ID de la vente principale (liaison)
        'id_produit',     // L'ID du médicament vendu
        'quantite',       // La quantité achetée par le client
        'prix_unitaire'   // Le prix du médicament au moment de la vente
    ];

    // 3. La relation pour pouvoir afficher le nom du produit sur la facture
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}