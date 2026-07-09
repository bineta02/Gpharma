@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Modifier le Fournisseur</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fournisseurs.index') }}">Fournisseurs</a></li>
        <li class="breadcrumb-item active">Modifier</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Modification : {{ $fournisseur->nom }}</h5>

            <form action="{{ route('fournisseurs.update', $fournisseur->id) }}" method="POST">
              @csrf
              @method('PUT')

              <!-- Nom du fournisseur -->
              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom / Raison Sociale <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" id="nom" value="{{ old('nom', $fournisseur->nom) }}" class="form-control @error('nom') is-invalid @enderror">
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Téléphone -->
              <div class="row mb-3">
                <label for="telephone" class="col-sm-3 col-form-label">Téléphone <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $fournisseur->telephone) }}" class="form-control @error('telephone') is-invalid @enderror">
                  @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Email -->
              <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email" id="email" value="{{ old('email', $fournisseur->email) }}" class="form-control @error('email') is-invalid @enderror">
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Adresse -->
              <div class="row mb-3">
                <label for="adresse" class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-9">
                  <textarea name="adresse" id="adresse" rows="2" class="form-control @error('adresse') is-invalid @enderror">{{ old('adresse', $fournisseur->adresse) }}</textarea>
                  @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Statut -->
              <div class="row mb-3">
                <label for="statut" class="col-sm-3 col-form-label">Statut <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                    <option value="actif" {{ old('statut', $fournisseur->statut) == 'actif' ? 'selected' : '' }}>Actif (Partenaire régulier)</option>
                    <option value="inactif" {{ old('statut', $fournisseur->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                  </select>
                  @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Boutons d'action -->
              <div class="row mb-2">
                <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                  <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-pencil-square me-1"></i> Mettre à jour
                  </button>
                  <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
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