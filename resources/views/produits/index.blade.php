@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Liste des Produits</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Produits</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('produits.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Ajouter un produit
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <!-- Barre de recherche -->
            <div class="d-flex justify-content-between align-items-center my-3">
              <h5 class="card-title p-0 m-0">Tous les Médicaments</h5>
              <form action="{{ route('produits.index') }}" method="GET" class="d-flex gap-2" style="max-width: 300px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher un produit...">
                <button type="submit" class="btn btn-secondary">
                  <i class="bi bi-search"></i>
                </button>
              </form>
            </div>

            <!-- Tableau des produits -->
            <div class="table-responsive">
              <table class="table align-middle backend-table">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th class="text-center">Stock Min</th>
                    <th class="text-center">Stock Max</th>
                    <th>Alertes</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($produits as $produit)
                    <tr>
                      <td><strong>{{ $produit->code }}</strong></td>
                      <td>
                        @if($produit->image)
                          <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                        @else
                          <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-image text-secondary fs-4"></i>
                          </div>
                        @endif
                      </td>
                      <td><span class="text-primary fw-bold">{{ $produit->nom }}</span></td>
                      <td><span class="badge bg-info-light text-info">{{ $produit->categorie->nom ?? 'Non définie' }}</span></td>
                      <td class="text-center"><span class="badge bg-danger-light text-danger">{{ $produit->stock_min }}</span></td>
                      <td class="text-center"><span class="badge bg-success-light text-success">{{ $produit->stock_max }}</span></td>
                      
                      <!-- Colonne Alertes réintégrée -->
                      <td>
                        <div class="d-flex flex-column gap-1">
                          @if($produit->enAlerteStock())
                            <span class="badge bg-danger text-white" style="font-size: 0.75rem;">
                              <i class="bi bi-exclamation-triangle-fill me-1"></i> Stock Faible
                            </span>
                          @else
                            <span class="badge bg-success-light text-success" style="font-size: 0.75rem;">Stock OK</span>
                          @endif

                          @if($produit->date_peremption)
                            @if($produit->enAlertePeremption())
                              <span class="badge bg-warning text-dark" style="font-size: 0.75rem;">
                                <i class="bi bi-hourglass-split me-1"></i> Périme bientôt
                              </span>
                            @else
                              <span class="badge bg-light text-muted" style="font-size: 0.75rem;">
                                Exp : {{ \Carbon\Carbon::parse($produit->date_peremption)->format('m/Y') }}
                              </span>
                            @endif
                          @endif
                        </div>
                      </td>

                      <td><small class="text-muted">{{ Str::limit($produit->description, 50) }}</small></td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-warning btn-sm text-white" title="Modifier">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce produit ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                              <i class="bi bi-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                        Aucun produit trouvé.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination épurée à deux boutons -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                @if ($produits->onFirstPage())
                  <button class="btn btn-secondary btn-sm" disabled>« Précédent</button>
                @else
                  <a href="{{ $produits->appends(['search' => request('search')])->previousPageUrl() }}" class="btn btn-primary btn-sm">« Précédent</a>
                @endif
              </div>

              <div>
                @if ($produits->hasMorePages())
                  <a href="{{ $produits->appends(['search' => request('search')])->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant »</a>
                @else
                  <button class="btn btn-secondary btn-sm" disabled>Suivant »</button>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection