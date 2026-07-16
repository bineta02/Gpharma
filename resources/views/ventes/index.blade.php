@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Liste des Ventes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Ventes</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('ventes.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Nouvelle Vente (Caisse)
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            
            <div class="d-flex justify-content-between align-items-center my-3">
              <h5 class="card-title p-0 m-0">Factures Clients</h5>
              <form action="{{ route('ventes.index') }}" method="GET" class="d-flex gap-2" style="max-width: 300px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="N° Facture...">
                <button type="submit" class="btn btn-secondary">
                  <i class="bi bi-search"></i>
                </button>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table align-middle backend-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>N° Facture</th>
                    <th class="text-end">Montant Total</th>
                    <th class="text-end">Reçu</th>
                    <th class="text-end">Rendu</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($ventes as $vente)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($vente->created_at)->format('d/m/Y H:i') }}</td>
                      <td><span class="text-primary fw-bold">{{ $vente->numero_facture }}</span></td>
                      <td class="text-end fw-bold">{{ number_format($vente->montant_total, 0, ',', ' ') }} F</td>
                      <td class="text-end text-muted">{{ number_format($vente->montant_recu, 0, ',', ' ') }} F</td>
                      <td class="text-end text-success">{{ number_format($vente->rendu_monnaie, 0, ',', ' ') }} F</td>
                      <td class="text-center">
                        @if($vente->statut == 'complete')
                          <span class="badge bg-success">Validée</span>
                        @else
                          <span class="badge bg-danger">Annulée / Retour</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <!-- Voir / Imprimer -->
                          <a href="{{ route('ventes.show', $vente->id) }}" class="btn btn-info btn-sm text-white" title="Facture & Impression">
                            <i class="bi bi-eye"></i>
                          </a>
                          
                          <!-- Annuler (Retour de stock) -->
                          @if($vente->statut == 'complete')
                            <form action="{{ route('ventes.annuler', $vente->id) }}" method="POST" onsubmit="return confirm('Annuler cette vente ? Les stocks seront réintégrés.')" style="display:inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="btn btn-danger btn-sm" title="Annuler / Retourner">
                                <i class="bi bi-trash"></i>
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                        Aucune vente trouvée.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                @if ($ventes->onFirstPage())
                  <button class="btn btn-secondary btn-sm" disabled>« Précédent</button>
                @else
                  <a href="{{ $ventes->appends(['search' => request('search')])->previousPageUrl() }}" class="btn btn-primary btn-sm">« Précédent</a>
                @endif
              </div>
              <div>
                @if ($ventes->hasMorePages())
                  <a href="{{ $ventes->appends(['search' => request('search')])->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant »</a>
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