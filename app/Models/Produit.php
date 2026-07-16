<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categorie', 
        'code',
        'nom',
        'prix',
        'description',
        'stock_min',
        'stock_max',
        'image',
        'date_peremption' // <-- Nouveau champ pour la péremption
    ];

    // Liaison : Un produit appartient à une catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    /**
     * Vérifie si le produit est en alerte stock (si le stock actuel est inférieur ou égal au stock_min)
     * Note: Pour l'examen, on simule que stock_max est votre stock actuel pour le test visuel,
     * ou vous comparerez avec votre colonne de quantité réelle.
     */
    public function enAlerteStock()
    {
        // Exemple : si le stock_max (quantité actuelle) passe sous le stock_min
        return $this->stock_max <= $this->stock_min;
    }

    /**
     * Vérifie si le produit expire bientôt (dans moins de 3 mois / 90 jours)
     */
    public function enAlertePeremption()
    {
        if (!$this->date_peremption) return false;
        
        $datePeremption = Carbon::parse($this->date_peremption);
        // Retourne vrai si la date actuelle a dépassé ou est à moins de 90 jours de la péremption
        return Carbon::now()->diffInDays($datePeremption, false) <= 90;
    }
}