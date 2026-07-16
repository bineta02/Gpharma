@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center no-print">
    <div>
      <h1>Facture Client</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('ventes.index') }}">Ventes</a></li>
          <li class="breadcrumb-item active">Facture N° {{ $vente->id }}</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <!-- Bouton d'impression de la facture -->
      <button onclick="window.print();" class="btn btn-warning text-white">
        <i class="bi bi-printer me-1"></i> Imprimer la Facture (PDF)
      </button>
      <a href="{{ route('ventes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show role="alert" class="no-print">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pt-4">
            
            <!-- EN-TÊTE DE LA FACTURE -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
              <div>
                <h3 class="mb-0 text-primary fw-bold">G-PHARMA S.A.</h3>
                <p class="text-muted mb-0 small">Pharmacie Centrale de Garde / Service Caisse</p>
                <p class="text-muted mb-0 small">Tél: +221 33 800 00 00 | Dakar, Sénégal</p>
              </div>
              <div class="text-end">
                <h4 class="text-dark fw-bold mb-1">{{ $vente->numero_facture }}</h4>
                <p class="text-muted mb-0">Date : {{ \Carbon\Carbon::parse($vente->created_at)->format('d/m/Y H:i') }}</p>
                <p class="mb-0 small">Statut : 
                  @if($vente->statut == 'complete')
                    <span class="text-success fw-bold text-uppercase">Validée</span>
                  @else
                    <span class="text-danger fw-bold text-uppercase">Annulée / Retournée</span>
                  @endif
                </p>
              </div>
            </div>

            <!-- INFOS TICKET -->
            <div class="row mb-4">
              <div class="col-12">
                <h6 class="text-muted text-uppercase small fw-bold">Type de document :</h6>
                <h5><strong>Facture de Vente Comptant</strong></h5>
              </div>
            </div>

            <!-- TABLEAU DES PRODUITS VENDUS -->
            <div class="table-responsive mb-4">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Désignation du Médicament</th>
                    <th class="text-center" style="width: 15%;">Quantité</th>
                    <th class="text-end" style="width: 20%;">Prix Unitaire</th>
                    <th class="text-end" style="width: 20%;">Montant Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($vente->details as $detail)
                    <tr>
                      <td>
                        <strong class="text-dark">{{ $detail->produit->nom ?? 'Produit inconnu' }}</strong>
                        <br><small class="text-muted">Code: {{ $detail->produit->code ?? 'N/A' }}</small>
                      </td>
                      <td class="text-center fw-bold">{{ $detail->quantite }}</td>
                      <td class="text-end">{{ number_format($detail->prix_unitaire, 0, ',', ' ') }} F</td>
                      <td class="text-end fw-bold text-dark">{{ number_format($detail->quantite * $detail->prix_unitaire, 0, ',', ' ') }} F</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- BLOC DES CALCULS FINAUX & MONNAIE -->
            <div class="row justify-content-end mb-4">
              <div class="col-md-5">
                <div class="p-3 bg-light rounded">
                  
                  <!-- Calculs financiers de base -->
                  @php
                    $totalTTC = $vente->montant_total;
                    $tva = $totalTTC * 0.18; // Exemple TVA à 18% incluse
                    $ht = $totalTTC - $tva;
                  @endphp

                  <div class="d-flex justify-content-between mb-2 small text-muted">
                    <span>Montant HT :</span>
                    <span>{{ number_format($ht, 0, ',', ' ') }} F</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2 small text-muted">
                    <span>TVA (18%) :</span>
                    <span>{{ number_format($tva, 0, ',', ' ') }} F</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2 border-top pt-2 fw-bold text-dark fs-5">
                    <span>NET À PAYER :</span>
                    <span class="text-primary">{{ number_format($totalTTC, 0, ',', ' ') }} FCFA</span>
                  </div>
                  
                  <!-- Infos Caisse (Espèces / Monnaie) -->
                  <div class="d-flex justify-content-between mb-1 mt-3 pt-2 border-top small text-muted">
                    <span>Montant Reçu :</span>
                    <span>{{ number_format($vente->montant_recu, 0, ',', ' ') }} F</span>
                  </div>
                  <div class="d-flex justify-content-between small text-success fw-bold">
                    <span>Rendu Monnaie :</span>
                    <span>{{ number_format($vente->rendu_monnaie, 0, ',', ' ') }} F</span>
                  </div>

                </div>
              </div>
            </div>

            <!-- PIED DE FACTURE DE CAISSE -->
            <div class="text-center pt-4 border-top mt-5 fs-6">
              <p class="mb-1 fw-bold">Merci de votre confiance !</p>
              <p class="text-muted small">Les médicaments vendus ne sont ni repris, ni échangés après validation hors processus réglementaire.</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- STYLE D'IMPRESSION NETTE -->
<style>
@media print {
  /* Masque tout l'environnement web NiceAdmin */
  .no-print, #header, #sidebar, footer, .btn, .breadcrumb, .alert {
    display: none !important;
  }
  
  /* Ajuste la zone d'impression */
  main {
    margin-left: 0 !important;
    padding: 0 !important;
    margin-top: 0 !important;
  }
  
  .card {
    border: none !important;
    box-shadow: none !important;
  }
}
</style>
@endsection