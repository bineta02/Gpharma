<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produits = Produit::with('categorie')
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%{$search}%")
                             ->orWhere('code', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::where('statut', 'actif')->get();
        return view('produits.create', compact('categories'));
    }

    /**
     * Enregistrer le produit avec la date de péremption
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_categorie'    => 'required|exists:categories,id',
            'code'            => 'required|string|unique:produits,code',
            'nom'             => 'required|string|max:255',
            'prix'            => 'required|numeric|min:0', 
            'description'     => 'nullable|string',
            'stock_min'       => 'required|integer|min:0',
            'stock_max'       => 'required|integer|min:0',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_peremption' => 'nullable|date', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Création de Vente',
    'description' => auth()->user()->name . ' a créé une nouvelle vente.',
    'ip_address' => request()->ip(),
]);

        return redirect()->route('produits.index')->with('success', 'Produit enregistré avec ses alertes !');
    }

    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::where('statut', 'actif')->get();

        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Création de Vente',
    'description' => auth()->user()->name . ' a créé une nouvelle vente.',
    'ip_address' => request()->ip(),
]);
        return view('produits.edit', compact('produit', 'categories'));
    }

    /**
     * Mettre à jour le produit avec la date de péremption
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_categorie'    => 'required|exists:categories,id',
            'code'            => 'required|string|unique:produits,code,' . $id,
            'nom'             => 'required|string|max:255',
            'description'     => 'nullable|string',
            'stock_min'       => 'required|integer|min:0',
            'stock_max'       => 'required|integer|min:0',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_peremption' => 'nullable|date', // <-- Validation de la date
        ]);

        $produit = Produit::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Création de Vente',
    'description' => auth()->user()->name . ' a créé une nouvelle vente.',
    'ip_address' => request()->ip(),
]);

        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès !');
    }

    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image && Storage::disk('public')->exists($produit->image)) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Création de Vente',
    'description' => auth()->user()->name . ' a créé une nouvelle vente.',
    'ip_address' => request()->ip(),
]);

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès !');
    }
}