@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Détails & Historique Client</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
          <li class="breadcrumb-item active">Historique</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-1"></i> Retour à la liste
    </a>
  </div>

  <section class="section profile">
    <div class="row">
      
      <!-- Fiche Info Client -->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <div class="avatar-circle mb-3 bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; font-size: 24px;">
              {{ strtoupper(substr($client->prenom, 0, 1)) }}{{ strtoupper(substr($client->nom, 0, 1)) }}
            </div>
            <h2>{{ $client->prenom }} {{ $client->nom }}</h2>
            <span class="badge bg-success-light text-success">{{ $client->statut ?? 'Actif' }}</span>
          </div>
          <div class="card-body pt-0">
            <hr>
            <p><strong><i class="bi bi-telephone me-2 text-primary"></i> Téléphone :</strong> {{ $client->telephone ?? 'N/A' }}</p>
            <p><strong><i class="bi bi-envelope me-2 text-primary"></i> Email :</strong> {{ $client->email ?? 'N/A' }}</p>
            <p><strong><i class="bi bi-geo-alt me-2 text-primary"></i> Adresse :</strong> {{ $client->adresse ?? 'N/A' }}</p>
            <div class="p-2 bg-light rounded">
              <strong class="small text-muted d-block"><i class="bi bi-journal-text me-1"></i> Note médicale/commerciale :</strong>
              <span class="small">{{ $client->note ?? 'Aucune note enregistrée.' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tableau de l'Historique des Achats -->
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <h5 class="card-title">Historique des achats passés</h5>

            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Réf Vente</th>
                    <th>Date</th>
                    <th>Médicaments achetés</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($client->ventes as $vente)
                    <tr>
                      <td class="fw-bold">#{{ $vente->id }}</td>
                      <td>{{ $vente->created_at->format('d/m/Y H:i') }}</td>
                      <td>
                        <!-- On boucle sur les détails de la vente pour lister les produits -->
                        @foreach($vente->details as $detail)
                          <span class="badge bg-secondary-light text-secondary mb-1">
                            {{ $detail->produit->nom }} (x{{ $detail->quantite }})
                          </span>
                        @endforeach
                      </td>
                      <td class="fw-bold text-success">{{ number_format($vente->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-exclamation-circle d-block fs-3 mb-2"></i>
                        Aucun achat enregistré pour ce client pour le moment.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>

</main>
@endsection