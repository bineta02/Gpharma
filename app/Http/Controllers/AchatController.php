<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // On prépare la requête de base
    $query = Achat::with(['produit', 'fournisseur']);

    // On n'applique le filtre que SI l'utilisateur a écrit quelque chose dans la barre de recherche
    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->whereHas('produit', function($p) use ($search) {
                $p->where('nom', 'like', "%{$search}%");
            })->orWhereHas('fournisseur', function($f) use ($search) {
                $f->where('nom', 'like', "%{$search}%");
            });
        });
    }

    // On récupère les résultats avec pagination quoi qu'il arrive
    $achats = $query->orderBy('created_at', 'desc')->paginate(10);

    // On injecte explicitement la variable à la vue
    return view('achats.index', compact('achats'));
}

    public function create()
    {
        $produits = Produit::all();
        $fournisseurs = Fournisseur::where('statut', 'actif')->get();
        return view('achats.create', compact('produits', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produit'     => 'required|exists:produits,id',
            'id_fournisseur' => 'required|exists:fournisseurs,id',
            'quantite'       => 'required|integer|min:1',
            'prix_unitaire'  => 'required|numeric|min:0',
        ]);

        // À la création, le bon d'achat est "en_attente" par défaut
        Achat::create([
            'id_produit'     => $request->id_produit,
            'id_fournisseur' => $request->id_fournisseur,
            'quantite'       => $request->quantite,
            'prix_unitaire'  => $request->prix_unitaire,
            'statut'         => 'en_attente'
        ]);

        return redirect()->route('achats.index')->with('success', 'Bon d\'achat créé en attente de réception.');
    }

    public function show($id)
    {
        $achat = Achat::with(['produit', 'fournisseur'])->findOrFail($id);
        return view('achats.show', compact('achat'));
    }

    // VALIDER / RÉCEPTIONNER : Change le statut et augmente le stock
    public function receptionner($id)
    {
        $achat = Achat::findOrFail($id);
        
        if ($achat->statut == 'en_attente') {
            $achat->statut = 'receptionne';
            $achat->save();

            // Mise à jour automatique du stock_max
            $achat->produit->increment('stock_max', $achat->quantite);

            return redirect()->back()->with('success', 'Commande réceptionnée ! Le stock a été incrémenté.');
        }

        return redirect()->back()->with('error', 'Ce bon ne peut pas être réceptionné.');
    }

    // ANNULER UN ACHAT : Rollback du stock si déjà réceptionné
    public function annuler($id)
    {
        $achat = Achat::findOrFail($id);

        if ($achat->statut == 'receptionne') {
            // Rollback du stock si les produits étaient déjà entrés
            $achat->produit->decrement('stock_max', $achat->quantite);
        }

        $achat->statut = 'annule';
        $achat->save();

        return redirect()->back()->with('success', 'Bon d\'achat annulé. Le stock a été réajusté.');
    }
}