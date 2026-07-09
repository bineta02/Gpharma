<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    // Autorise le remplissage de ces colonnes en base de données
protected $fillable = ['nom', 'description', 'image', 'statut'];}