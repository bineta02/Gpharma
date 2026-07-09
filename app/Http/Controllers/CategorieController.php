<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategorieController extends Controller
{
    // 1. Liste des catégories
    public function index(Request $request) {
    // Récupérer le mot recherché
    $search = $request->input('search');

    // Construire la requête
    $categories = Categorie::query()
        ->when($search, function($query) use ($search) {
            return $query->where('nom', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->paginate(5); // On garde 5 éléments par page

    return view('categories.index', compact('categories', 'search'));
}

    // 2. Formulaire de création
    public function create()
    {
        return view('categories.create');
    }

    // 3. Enregistrement dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'required|in:actif,inactif',
        ]);

        $data = $request->all();

        // Gestion du téléversement de l'image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Categorie::create($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    // 4. Formulaire de modification
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('categories.edit', compact('categorie'));
    }

    // 5. Mise à jour de la catégorie
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'required|in:actif,inactif',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($categorie->image) {
                Storage::disk('public')->delete($categorie->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $categorie->update($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    // 6. Suppression
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Supprimer l'image associée du stockage
        if ($categorie->image) {
            Storage::disk('public')->delete($categorie->image);
        }

        $categorie->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }

    
}