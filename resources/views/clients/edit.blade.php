@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Modifier le Client</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
          <li class="breadcrumb-item active">Modifier</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-1"></i> Annuler
    </a>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body pt-4">

            <form action="{{ route('clients.update', $client->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row mb-3">
                <label for="prenom" class="col-sm-3 col-form-label fw-bold">Prénom</label>
                <div class="col-sm-9">
                  <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $client->prenom) }}" placeholder="Ex: Jean">
                </div>
              </div>

              <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label fw-bold">Nom  <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $client->nom) }}" required>
                  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="telephone" class="col-sm-3 col-form-label fw-bold">Téléphone</label>
                <div class="col-sm-9">
                  <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}">
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label fw-bold">Adresse Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                </div>
              </div>

              <div class="row mb-3">
                <label for="adresse" class="col-sm-3 col-form-label fw-bold">Adresse Physique</label>
                <div class="col-sm-9">
                  <textarea name="adresse" id="adresse" class="form-control" rows="3">{{ old('adresse', $client->adresse) }}</textarea>
                </div>
              </div>

              <div class="row mb-3">
  <label for="note" class="col-sm-3 col-form-label fw-bold">Notes / Observations</label>
  <div class="col-sm-9">
    <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $client->note) }}</textarea>
  </div>
</div>

              <div class="row mb-2">
                <div class="col-sm-9 offset-sm-3">
                  <button type="submit" class="btn btn-warning text-dark">
                    <i class="bi bi-arrow-clockwise me-1"></i> Mettre à jour
                  </button>
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