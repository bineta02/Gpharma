<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\VenteDetail;
use App\Models\Produit;
use App\Models\Achat; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RapportController extends Controller
{
    public function index()
    {
        // 1. CHIFFRE D'AFFAIRES PAR PÉRIODE
        $caJour = Vente::whereDate('created_at', Carbon::today())->sum('montant_total');
        $caSemaine = Vente::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('montant_total');
        $caMois = Vente::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('montant_total');

        // 2. TOTAL DES ACHATS FOURNISSEURS (Basé sur quantite * prix_unitaire de ta table achats)
        $achatsMois = class_exists(Achat::class) 
            ? Achat::whereMonth('created_at', Carbon::now()->month)
                ->select(DB::raw('SUM(quantite * prix_unitaire) as total_achat'))
                ->value('total_achat') ?? 0 
            : 0;

        // 3. RAPPORT DE STOCK
        $totalProduits = Produit::count();
        $produitsEpuises = Produit::where('stock_max', '<=', 0)->get();
        
        // Alerte si le stock actuel est inférieur ou égal au stock minimal défini pour le médicament
        $alertesStock = Produit::where('stock_max', '>', 0)
            ->whereRaw('stock_max <= stock_min')
            ->get();
        
        // Valeur totale du stock estimée sur ton prix de vente (stock_max * prix)
        $valeurStock = Produit::select(DB::raw('SUM(stock_max * prix) as total'))->value('total') ?? 0;

        // 4. TOP PRODUITS PLUS VENDUS (Top 5)
        $topProduits = VenteDetail::select('id_produit', DB::raw('SUM(quantite) as total_vendu'))
            ->with('produit')
            ->groupBy('id_produit')
            ->orderByDesc('total_vendu')
            ->take(5)
            ->get();

        // 5. RAPPORT MARGE BÉNÉFICIAIRE (Mis à 0 ou estimé à 20% du CA par exemple pour l'instant)
        // Comme tu n'as pas de prix_achat dans produits, on estime la marge à 20% du chiffre d'affaires du mois
        $margeGlobale = $caMois * 0.20; 

        // 6. DONNÉES DU GRAPHIQUE (Ventes des 7 derniers jours)
        $jours = [];
        $ventesParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $jours[] = $date->format('d M');
            $ventesParJour[] = Vente::whereDate('created_at', $date->toDateString())->sum('montant_total');
        }

        return view('rapports.index', compact(
            'caJour', 'caSemaine', 'caMois', 'achatsMois',
            'totalProduits', 'produitsEpuises', 'alertesStock', 'valeurStock',
            'topProduits', 'margeGlobale', 'jours', 'ventesParJour'
        ));
    }

    public function exportExcel()
{
    // Récupérer les données des produits en alerte ou épuisés pour le rapport
    $produits = \App\Models\Produit::all();

    $fileName = 'rapport_stock_' . date('Y-m-d') . '.csv';

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['Code', 'Nom du Medicament', 'Stock Actuel', 'Stock Minimum', 'Prix de Vente (FCFA)', 'Statut'];

    $callback = function() use($produits, $columns) {
        $file = fopen('php://output', 'w');
        // Ajouter la ligne d'en-tête (UTF-8 support pour Excel)
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($file, $columns, ';');

        foreach ($produits as $produit) {
            // Déterminer le statut du stock
            if ($produit->stock_max <= 0) {
                $statut = 'Epuisé';
            } elseif ($produit->stock_max <= $produit->stock_min) {
                $statut = 'Alerte';
            } else {
                $statut = 'Ok';
            }

            fputcsv($file, [
                $produit->code ?? 'N/A',
                $produit->nom,
                $produit->stock_max,
                $produit->stock_min,
                $produit->prix,
                $statut
            ], ';');
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}