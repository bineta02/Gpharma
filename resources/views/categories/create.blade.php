@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Ajouter une Catégorie</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
        <li class="breadcrumb-item active">Créer</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nouvelle Catégorie</h5>

            <!-- Formulaire connecté à la route Store (Ne pas oublier enctype pour l'image) -->
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
              </div>

              <div class="row mb-3">
                <label for="image" class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-9">
                  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                  @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
    <label for="statut" class="col-sm-3 col-form-label">Statut <span class="text-danger">*</span></label>
    <div class="col-sm-9">
      <select name="statut" id="statut" class="form-select" required>
        <option value="actif" selected>Actif</option>
        <option value="inactif">Inactif</option>
      </select>
    </div>
</div>

              <div class="text-end">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection