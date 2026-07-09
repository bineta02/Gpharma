@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Historique des Achats</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fournisseurs.index') }}">Fournisseurs</a></li>
        <li class="breadcrumb-item active">Détails</li>
      </ol>
    </nav>
  </div>

  <section class="section profile">
    <div class="row">
      
      <!-- Fiche Résumé du Fournisseur -->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <div class="bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-building fs-3"></i>
            </div>
            <h2>{{ $fournisseur->nom }}</h2>
            <span class="badge {{ $fournisseur->statut == 'actif' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }} mb-3">
              {{ ucfirst($fournisseur->statut) }}
            </span>
            
            <div class="w-100 text-muted small mt-2">
              <p class="mb-1"><i class="bi bi-telephone me-2"></i>{{ $fournisseur->telephone }}</p>
              <p class="mb-1"><i class="bi bi-envelope me-2"></i>{{ $fournisseur->email ?? 'Non renseigné' }}</p>
              <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $fournisseur->adresse ?? 'Aucune adresse' }}</p>
            </div>
            
            <hr class="w-100">
            <div class="text-center">
              <small class="text-muted d-block">Total Commandé</small>
              <span class="fs-4 fw-bold text-success">{{ number_format($totalDepense, 2, ',', ' ') }} FCFA</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tableau de l'Historique -->
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <h5 class="card-title">Liste des approvisionnements effectués</h5>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Médicament</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-right">P.U Achat</th>
                    <th class="text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($fournisseur->achats as $achat)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($achat->date_achat)->format('d/m/Y') }}</td>
                      <td>
                        <span class="fw-bold text-primary">{{ $achat->produit->nom ?? 'Produit supprimé' }}</span>
                        <br><small class="text-muted">{{ $achat->produit->code ?? '' }}</small>
                      </td>
                      <td class="text-center"><span class="badge bg-light text-dark">{{ $achat->quantite }}</span></td>
                      <td>{{ number_format($achat->prix_achat_unitaire, 2, ',', ' ') }} F</td>
                      <td class="fw-bold text-secondary">{{ number_format($achat->montant_total, 2, ',', ' ') }} F</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-receipt fs-3 d-block mb-2"></i>
                        Aucun achat enregistré auprès de ce fournisseur.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="mt-3">
              <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
              </a>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
</main>
@endsection