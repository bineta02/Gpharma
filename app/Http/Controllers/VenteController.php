<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\VenteDetail;
use App\Models\Produit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteController extends Controller
{
    // Liste de l'historique des ventes
    public function index(Request $request)
    {
        $search = $request->input('search');

        $ventes = Vente::when($search, function($query) use ($search) {
                $query->where('numero_facture', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('ventes.index', compact('ventes'));
    }

    // Interface de caisse POS (Formulaire de création)
    public function create()
{
    // Remplacer 'stock' par 'stock_max'
    $produits = Produit::where('stock_max', '>', 0)->get(); 
    $clients = Client::orderBy('nom')->get();
    
    return view('ventes.create', compact('produits', 'clients'));
}

    // Enregistrement de la vente (Validation du panier et déstockage)
   public function store(Request $request)
{
    // 1. Validation de la requête (id_client est optionnel/nullable)
    $request->validate([
        'id_client' => 'nullable|exists:clients,id', // <-- Ajouté pour lier le client
        'produits' => 'required|array',
        'produits.*.id' => 'required|exists:produits,id',
        'produits.*.quantite' => 'required|integer|min:1',
        'montant_recu' => 'required|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        $montantTotal = 0;
        $details = [];

        foreach ($request->produits as $item) {
            $produit = Produit::findOrFail($item['id']);
            
            if ($produit->stock_max < $item['quantite']) {
                return redirect()->back()->withInput()->with('error', "Stock insuffisant pour : {$produit->nom}.");
            }

            // Récupération du nouveau prix depuis la base de données
            $prixUnitaire = $produit->prix; 
            $sousTotal = $prixUnitaire * $item['quantite'];
            $montantTotal += $sousTotal;

            $details[] = [
                'id_produit' => $produit->id,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $prixUnitaire,
                'produit_model' => $produit
            ];
        }

        if ($request->montant_recu < $montantTotal) {
            return redirect()->back()->withInput()->with('error', "Le montant reçu est insuffisant.");
        }

        // 2. Création de la vente (avec id_client)
        $vente = Vente::create([
            'id_client' => $request->id_client, // <-- L'assignation se fait ici !
            'numero_facture' => 'FAC-' . date('YmdHis'),
            'montant_total' => $montantTotal,
            'montant_recu' => $request->montant_recu,
            'rendu_monnaie' => $request->montant_recu - $montantTotal,
            'statut' => 'complete'
        ]);

        foreach ($details as $detail) {
            VenteDetail::create([
                'id_vente' => $vente->id,
                'id_produit' => $detail['id_produit'],
                'quantite' => $detail['quantite'],
                'prix_unitaire' => $detail['prix_unitaire'],
            ]);

            $detail['produit_model']->decrement('stock_max', $detail['quantite']);
        }

        DB::commit();
        return redirect()->route('ventes.show', $vente->id)->with('success', 'Vente enregistrée !');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
    }
}

    // Vue complète d'une facture (Show)
    public function show($id)
    {
        $vente = Vente::with('details.produit')->findOrFail($id);
        return view('ventes.show', compact('vente'));
    }

    // Annuler / Rembourser (Gestion des retours avec réajustement du stock)
    public function annuler($id)
    {
        $vente = Vente::with('details.produit')->findOrFail($id);

        if ($vente->statut == 'annule') {
            return redirect()->back()->with('error', 'Cette vente est déjà annulée.');
        }

        try {
            DB::beginTransaction();

            // Restitution des stocks
            foreach ($vente->details as $detail) {
                if ($detail->produit) {
                    $detail->produit->increment('stock_max', $detail->quantite);
                }
            }

            // Changement de statut
            $vente->statut = 'annule';
            $vente->save();

            DB::commit();
            return redirect()->route('ventes.index')->with('success', 'La vente a été annulée et les produits ont été réintégrés au stock.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }
}