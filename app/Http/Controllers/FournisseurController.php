<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $fournisseurs = Fournisseur::when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('telephone', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'email'     => 'nullable|email|unique:fournisseurs,email',
            'telephone' => 'required|string|max:20',
            'adresse'   => 'nullable|string',
            'statut'    => 'required|in:actif,inactif',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur ajouté avec succès !');
    }

    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'email'     => 'nullable|email|unique:fournisseurs,email,' . $id,
            'telephone' => 'required|string|max:20',
            'adresse'   => 'nullable|string',
            'statut'    => 'required|in:actif,inactif',
        ]);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($request->all());

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé avec succès !');
    }

    public function show($id)
{
    // On récupère le fournisseur avec tous ses achats et les produits associés
    $fournisseur = Fournisseur::with(['achats.produit'])->findOrFail($id);
    
    // On calcule le montant total dépensé chez ce fournisseur (optionnel mais top pour l'examen)
    $totalDepense = $fournisseur->achats->sum('montant_total');

    return view('fournisseurs.show', compact('fournisseur', 'totalDepense'));
}
}