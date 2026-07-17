<?php

namespace App\Http\Controllers;

use App\Models\Produit; 
use App\Models\Vente;     
use App\Models\Fournisseur; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduits = \App\Models\Produit::count(); 
        
        $totalVentes = \App\Models\Vente::sum('montant_total'); 
        
       // Si ta colonne s'appelle 'statut' et la valeur est 'actif' :
       $totalFournisseurs = \App\Models\Fournisseur::where('statut', 'actif')->count();
        return view('home', compact('totalProduits', 'totalVentes', 'totalFournisseurs'));
    }
}