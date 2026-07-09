@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Historique des Achats</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Achats</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('achats.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Enregistrer un achat
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
              <h5 class="card-title p-0 m-0">Commandes Fournisseurs & Stocks</h5>
              <form action="{{ route('achats.index') }}" method="GET" class="d-flex gap-2" style="max-width: 300px;">
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
                    <th>Date</th>
                    <th>Médicament</th>
                    <th>Fournisseur</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-end">Prix Unitaire</th>
                    <th class="text-end">Montant Total</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($achats as $achat)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($achat->created_at)->format('d/m/Y') }}</td>
                      <td>
                        <span class="text-primary fw-bold">{{ $achat->produit->nom ?? 'Produit inconnu' }}</span>
                        <br><small class="text-muted">{{ $achat->produit->code ?? '' }}</small>
                      </td>
                      <td><strong>{{ $achat->fournisseur->nom ?? 'Inconnu' }}</strong></td>
                      <td class="text-center"><span class="badge bg-light text-dark fs-6">{{ $achat->quantite }}</span></td>
                      <td class="text-end">{{ number_format($achat->prix_unitaire, 0, ',', ' ') }} F</td>
                      <td class="text-end fw-bold text-dark">{{ number_format($achat->quantite * $achat->prix_unitaire, 0, ',', ' ') }} F</td>
                      <td class="text-center">
                        @if($achat->statut == 'en_attente')
                          <span class="badge bg-warning text-dark">En attente</span>
                        @elseif($achat->statut == 'receptionne')
                          <span class="badge bg-success">Réceptionné</span>
                        @else
                          <span class="badge bg-danger">Annulé</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <!-- Bouton Voir Détails & Impression -->
                          <a href="{{ route('achats.show', $achat->id) }}" class="btn btn-info btn-sm text-white" title="Voir le détail / Imprimer">
                            <i class="bi bi-eye"></i>
                          </a>
                          
                          <!-- Bouton Valider / Réceptionner -->
                          @if($achat->statut == 'en_attente')
                            <form action="{{ route('achats.receptionner', $achat->id) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="btn btn-success btn-sm" title="Réceptionner la commande">
                                <i class="bi bi-check-lg"></i>
                              </button>
                            </form>
                          @endif

                          <!-- Bouton Annuler (Rollback du stock) -->
                          @if($achat->statut != 'annule')
                            <form action="{{ route('achats.annuler', $achat->id) }}" method="POST" onsubmit="return confirm('Annuler ce bon d\'achat ? (Le stock sera réajusté)')" style="display:inline;">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="btn btn-danger btn-sm" title="Annuler le bon">
                                <i class="bi bi-x-circle"></i>
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                        Aucun bon d'achat trouvé.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                @if ($achats->onFirstPage())
                  <button class="btn btn-secondary btn-sm" disabled>« Précédent</button>
                @else
                  <a href="{{ $achats->appends(['search' => request('search')])->previousPageUrl() }}" class="btn btn-primary btn-sm">« Précédent</a>
                @endif
              </div>
              <div>
                @if ($achats->hasMorePages())
                  <a href="{{ $achats->appends(['search' => request('search')])->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant »</a>
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