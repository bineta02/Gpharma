@extends('layouts.app')

@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion Pharmacie</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Catégories</li>
          <li class="breadcrumb-item active">Liste</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Plan de Tâches — Liste des Catégories</h5>
                <!-- Lien vers le formulaire de création -->
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                  <i class="bi bi-plus-circle"></i> Créer une catégorie
                </a>
              </div>

              <!-- Message de Succès Flash Dynamique -->
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle me-1"></i>
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <!-- Zone de recherche -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <form action="{{ route('categories.index') }}" method="GET" class="d-flex">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher une catégorie...">
    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
</form>
                </div>
              </div>

              <table class="table table-borderless datatable align-middle">
                <thead>
                  <tr class="table-light">
                    <th scope="col" style="width: 5%;">ID</th>
                    <th scope="col" style="width: 10%;">Image</th>
                    <th scope="col" style="width: 20%;">Nom</th>
                    <th scope="col" style="width: 40%;">Description</th>
                    <th scope="col" style="width: 10%;">Statut</th>
                    <th scope="col" style="width: 15%;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($categories as $categorie)
                    <tr>
                      <!-- Affichage de l'ID réel de la table -->
                      <th scope="row">#{{ $categorie->id }}</th>
                      
                      <!-- Gestion de l'image -->
                      <td>
                        @if($categorie->image)
                          <img src="{{ asset('storage/' . $categorie->image) }}" alt="{{ $categorie->nom }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                          <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-image" style="font-size: 1.2rem;"></i>
                          </div>
                        @endif
                      </td>

                      <td class="fw-bold text-primary">{{ $categorie->nom }}</td>
                      <td>{{ $categorie->description ?? 'Aucune description fournie' }}</td>
                      
                      <!-- Gestion du badge de statut -->
                      <td>
                        @if($categorie->statut == 'actif' || $categorie->statut == 1)
                          <span class="badge bg-success">Actif</span>
                        @else
                          <span class="badge bg-danger">Inactif</span>
                        @endif
                      </td>

                      <td class="text-center">
                        <!--  Bouton de modification -->
                        <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        
                        <!--  Formulaire et bouton de suppression -->
                        <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center text-muted py-3">Aucune catégorie trouvée.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>

              <!-- Pagination automatique de Laravel Bootstrap -->
              <div class="d-flex justify-content-between align-items-center mt-3">
    <!-- Bouton Précédent -->
    @if ($categories->onFirstPage())
        <button class="btn btn-secondary btn-sm" disabled>« Précédent</button>
    @else
        <a href="{{ $categories->appends(['search' => $search])->previousPageUrl() }}" class="btn btn-primary btn-sm">« Précédent</a>
    @endif

    <!-- Bouton Suivant -->
    @if ($categories->hasMorePages())
        <a href="{{ $categories->appends(['search' => $search])->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant »</a>
    @else
        <button class="btn btn-secondary btn-sm" disabled>Suivant »</button>
    @endif
</div>

          </div>
        </div>

      </div>
    </section>

  </main>

@endsection