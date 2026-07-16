@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Liste des Fournisseurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Fournisseurs</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Ajouter un fournisseur
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
            
            <div class="d-flex justify-content-between align-items-center my-3">
              <h5 class="card-title p-0 m-0">Partenaires & Grossistes</h5>
              <form action="{{ route('fournisseurs.index') }}" method="GET" class="d-flex gap-2" style="max-width: 300px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Rechercher...">
                <button type="submit" class="btn btn-secondary">
                  <i class="bi bi-search"></i>
                </button>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table align-middle backend-table">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($fournisseurs as $fournisseur)
                    <tr>
                      <td><span class="text-primary fw-bold">{{ $fournisseur->nom }}</span></td>
                      <td><strong>{{ $fournisseur->telephone }}</strong></td>
                      <td><span class="text-muted">{{ $fournisseur->email ?? 'N/A' }}</span></td>
                      <td><small>{{ $fournisseur->adresse ?? 'N/A' }}</small></td>
                      <td class="text-center">
                        @if($fournisseur->statut == 'actif')
                          <span class="badge bg-success-light text-success">Actif</span>
                        @else
                          <span class="badge bg-danger-light text-danger">Inactif</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <a href="{{ route('fournisseurs.show', $fournisseur->id) }}" class="btn btn-info btn-sm text-white" title="Voir l'historique">
                            <i class="bi bi-eye"></i>
                          </a>
                          
                          <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}" class="btn btn-warning btn-sm text-white" title="Modifier">
                            <i class="bi bi-pencil"></i>
                          </a>

                          <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}" method="POST" onsubmit="return confirm('Supprimer ce fournisseur ?')" style="display:inline;">
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
                      <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                        Aucun fournisseur trouvé.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                @if ($fournisseurs->onFirstPage())
                  <button class="btn btn-secondary btn-sm" disabled>« Précédent</button>
                @else
                  <a href="{{ $fournisseurs->appends(['search' => request('search')])->previousPageUrl() }}" class="btn btn-primary btn-sm">« Précédent</a>
                @endif
              </div>
              <div>
                @if ($fournisseurs->hasMorePages())
                  <a href="{{ $fournisseurs->appends(['search' => request('search')])->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant »</a>
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