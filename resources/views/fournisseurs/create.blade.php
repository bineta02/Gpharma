@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Ajouter un Fournisseur</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fournisseurs.index') }}">Fournisseurs</a></li>
        <li class="breadcrumb-item active">Nouveau</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Informations du Fournisseur</h5>

            <form action="{{ route('fournisseurs.store') }}" method="POST">
              @csrf

              <!-- Nom du fournisseur -->
              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom / Raison Sociale <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="form-control @error('nom') is-invalid @enderror" placeholder="Ex: Grossiste Pharma Plus">
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Téléphone -->
              <div class="row mb-3">
                <label for="telephone" class="col-sm-3 col-form-label">Téléphone <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="form-control @error('telephone') is-invalid @enderror" placeholder="Ex: +221 77 000 00 00">
                  @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Email -->
              <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Ex: contact@pharma.com">
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Adresse -->
              <div class="row mb-3">
                <label for="adresse" class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-9">
                  <textarea name="adresse" id="adresse" rows="2" class="form-control @error('adresse') is-invalid @enderror" placeholder="Ex: Rue 10, Dakar, Sénégal">{{ old('adresse') }}</textarea>
                  @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Statut -->
              <div class="row mb-3">
                <label for="statut" class="col-sm-3 col-form-label">Statut <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                    <option value="actif" {{ old('statut', 'actif') == 'actif' ? 'selected' : '' }}>Actif (Partenaire régulier)</option>
                    <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                  </select>
                  @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Boutons d'action -->
              <div class="row mb-2">
                <div class="col-sm-9 offset-sm-3 d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
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