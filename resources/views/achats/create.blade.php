@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Enregistrer un Nouvel Achat</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('achats.index') }}">Achats</a></li>
        <li class="breadcrumb-item active">Nouvel Approvisionnement</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulaire d'approvisionnement</h5>

            <form action="{{ route('achats.store') }}" method="POST">
              @csrf

              <!-- Sélection du Médicament -->
              <div class="row mb-3">
                <label for="id_produit" class="col-sm-3 col-form-label">Médicament <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select name="id_produit" id="id_produit" class="form-select @error('id_produit') is-invalid @enderror">
                    <option value="">-- Choisir le produit à approvisionner --</option>
                    @foreach($produits as $produit)
                      <option value="{{ $produit->id }}" {{ old('id_produit') == $produit->id ? 'selected' : '' }}>
                        {{ $produit->nom }} (Code: {{ $produit->code }} | Stock actuel: {{ $produit->stock_max }})
                      </option>
                    @endforeach
                  </select>
                  @error('id_produit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Sélection du Fournisseur -->
              <div class="row mb-3">
                <label for="id_fournisseur" class="col-sm-3 col-form-label">Fournisseur <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select name="id_fournisseur" id="id_fournisseur" class="form-select @error('id_fournisseur') is-invalid @enderror">
                    <option value="">-- Choisir le grossiste --</option>
                    @foreach($fournisseurs as $fournisseur)
                      <option value="{{ $fournisseur->id }}" {{ old('id_fournisseur') == $fournisseur->id ? 'selected' : '' }}>
                        {{ $fournisseur->nom }}
                      </option>
                    @endforeach
                  </select>
                  @error('id_fournisseur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Quantité achetée -->
              <div class="row mb-3">
                <label for="quantite" class="col-sm-3 col-form-label">Quantité <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="number" name="quantite" id="quantite" value="{{ old('quantite') }}" min="1" class="form-control @error('quantite') is-invalid @enderror" placeholder="Ex: 50">
                  @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Prix Unitaire d'Achat -->
              <div class="row mb-3">
                <label for="prix_unitaire" class="col-sm-3 col-form-label">Prix Unitaire (F) <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="number" name="prix_unitaire" id="prix_unitaire" value="{{ old('prix_unitaire') }}" min="0" class="form-control @error('prix_unitaire') is-invalid @enderror" placeholder="Ex: 1500">
                  @error('prix_unitaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Statut caché par défaut à 'livré'  -->
              <input type="hidden" name="statut" value="livre">

              <!-- Boutons d'action -->
              <div class="row mb-2">
                <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cart-plus me-1"></i> Confirmer l'achat
                  </button>
                  <a href="{{ route('achats.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection