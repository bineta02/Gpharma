@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Modifier la Catégorie</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Modifier : {{ $categorie->nom }}</h5>

            <form action="{{ route('categories.update', $categorie->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $categorie->nom) }}" required>
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea name="description" class="form-control" rows="3">{{ old('description', $categorie->description) }}</textarea>
                </div>
              </div>

              <div class="row mb-3">
                <label for="image" class="col-sm-3 col-form-label">Image actuelle</label>
                <div class="col-sm-9">
                  @if($categorie->image)
                    <img src="{{ asset('storage/' . $categorie->image) }}" class="img-thumbnail mb-2" style="max-width: 100px;">
                  @endif
                  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                  @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="mb-3">
    <label for="statut" class="form-label">Statut</label>
    <select class="form-select" name="statut" id="statut">
        <option value="actif" {{ $categorie->statut == 'actif' ? 'selected' : '' }}>Actif</option>
        <option value="inactif" {{ $categorie->statut == 'inactif' ? 'selected' : '' }}>Inactif</option>
    </select>
</div>

              <div class="text-end">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success">Mettre à jour</button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection