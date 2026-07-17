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
    $totalFournisseurs = \App\Models\Fournisseur::where('statut', 'actif')->count();

    
    $recentSales = \App\Models\Vente::latest()->take(5)->get();

    return view('home', compact('totalProduits', 'totalVentes', 'totalFournisseurs', 'recentSales'));
}
}