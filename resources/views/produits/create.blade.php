@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Ajouter un Produit</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
        <li class="breadcrumb-item active">Créer</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nouveau Médicament / Produit</h5>

            <!-- Formulaire connecté à la route de stockage des produits -->
            <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <!-- Code du produit -->
              <div class="row mb-3">
                <label for="code" class="col-sm-3 col-form-label">Code Produit / Barre <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="Ex: MED-1002" required>
                  @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Nom du produit -->
              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom Commercial <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
  <label for="prix" class="col-sm-2 col-form-label">Prix de Vente (F CFA)</label>
  <div class="col-sm-10">
    <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix', 0) }}" min="0" required>
  </div>
</div>

              <!-- Sélection de la Catégorie (id_categorie) -->
              <div class="row mb-3">
                <label for="id_categorie" class="col-sm-3 col-form-label">Catégorie <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select name="id_categorie" id="id_categorie" class="form-select @error('id_categorie') is-invalid @enderror" required>
                    <option value="" selected disabled>Choisir une catégorie...</option>
                    @foreach($categories as $categorie)
                      <option value="{{ $categorie->id }}" {{ old('id_categorie') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                      </option>
                    @endforeach
                  </select>
                  @error('id_categorie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Stocks Minimum et Maximum -->
              <div class="row mb-3">
                <label for="stock_min" class="col-sm-3 col-form-label">Stock Minimum <span class="text-danger">*</span></label>
                <div class="col-sm-3">
                  <input type="number" name="stock_min" class="form-control @error('stock_min') is-invalid @enderror" value="{{ old('stock_min', 0) }}" required>
                  @error('stock_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <label for="stock_max" class="col-sm-3 col-form-label text-end">Stock Maximum <span class="text-danger">*</span></label>
                <div class="col-sm-3">
                  <input type="number" name="stock_max" class="form-control @error('stock_max') is-invalid @enderror" value="{{ old('stock_max', 100) }}" required>
                  @error('stock_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Description -->
              <div class="row mb-3">
                <label for="description" class="col-sm-3 col-form-label">Description / Forme</label>
                <div class="col-sm-9">
                  <textarea name="description" class="form-control" rows="3" placeholder="Ex: Comprimé 500mg, Boîte de 30...">{{ old('description') }}</textarea>
                </div>
              </div>

              <!-- Image du produit -->
              <div class="row mb-3">
                <label for="image" class="col-sm-3 col-form-label">Image (Optionnel)</label>
                <div class="col-sm-9">
                  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                  @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Date de péremption -->
<div class="row mb-3">
    <label for="date_peremption" class="col-sm-3 col-form-label">Date de Péremption</label>
    <div class="col-sm-9">
        <input type="date" name="date_peremption" class="form-control @error('date_peremption') is-invalid @enderror" value="{{ old('date_peremption', $produit->date_peremption ?? '') }}">
        @error('date_peremption') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

              <!-- Boutons d'action -->
              <div class="text-end">
                <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer le produit</button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection