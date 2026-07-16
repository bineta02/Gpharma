<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Affiche la liste des clients
    public function index()
    {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    // Formulaire de création
    public function create()
    {
        return view('clients.create');
    }

    // Enregistrement d'un nouveau client
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès !');
    }

    // Formulaire de modification
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // Mise à jour du client
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
            'adresse'   => 'nullable|string',
            'statut'    => 'nullable|string',
            'note'      => 'nullable|string',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès !');
    }

    public function show(Client $client)
{
    // On charge le client et toutes ses ventes ainsi que les produits associés à chaque vente
    $client->load('ventes.details.produit');
    
    return view('clients.show', compact('client'));
}

    // Suppression du client
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès !');
    }
}