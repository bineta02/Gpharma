@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center no-print">
    <div>
      <h1>Détails du Bon d'Achat</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('achats.index') }}">Achats</a></li>
          <li class="breadcrumb-item active">Bon N° {{ $achat->id }}</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <!-- Bouton magique d'impression -->
      <button onclick="window.print();" class="btn btn-warning text-white">
        <i class="bi bi-printer me-1"></i> Imprimer le Bon (PDF)
      </button>
      <a href="{{ route('achats.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
      </a>
    </div>
  </div>

  <section class="section profile">
    <div class="row">
      <div class="col-xl-12">
        <div class="card id-invoice">
          <div class="card-body pt-4">
            
            <!-- Entête style facture / bon de commande -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
              <div>
                <h3 class="mb-0 text-primary fw-bold">BON DE COMMANDE FOURNISSEUR</h3>
                <p class="text-muted mb-0">Date : {{ \Carbon\Carbon::parse($achat->created_at)->format('d/m/Y à H:i') }}</p>
              </div>
              <div class="text-end">
                <h5 class="mb-1"><strong>Référence :</strong> ACH-{{ str_pad($achat->id, 5, '0', STR_PAD_LEFT) }}</h5>
                <h5><strong>Statut :</strong> <span class="text-uppercase fw-bold text-success">{{ $achat->statut }}</span></h5>
              </div>
            </div>

            <!-- Adresses Destinataire / Émetteur -->
            <div class="row mb-5">
              <div class="col-6">
                <h6 class="text-muted text-uppercase small fw-bold">Fournisseur :</h6>
                <h5><strong>{{ $achat->fournisseur->nom ?? 'Inconnu' }}</strong></h5>
                <p class="mb-0 text-muted">{{ $achat->fournisseur->telephone ?? '' }}</p>
                <p class="text-muted">{{ $achat->fournisseur->adresse ?? '' }}</p>
              </div>
              <div class="col-6 text-end">
                <h6 class="text-muted text-uppercase small fw-bold">Livrer à :</h6>
                <h5><strong>G-Pharma S.A.</strong></h5>
                <p class="mb-0 text-muted">Service de Gestion des Stocks</p>
                <p class="text-muted">Pharmacie Centrale de Garde</p>
              </div>
            </div>

            <!-- Tableau d'impression des lignes de commande -->
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
                  <tr>
                    <td>
                      <strong class="text-dark">{{ $achat->produit->nom ?? 'Produit inconnu' }}</strong>
                      @if(isset($achat->produit->code))
                        <br><small class="text-muted">Code: {{ $achat->produit->code }}</small>
                      @endif
                    </td>
                    <td class="text-center fw-bold">{{ $achat->quantite }}</td>
                    <td class="text-end">{{ number_format($achat->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td class="text-end fw-bold text-dark">{{ number_format($achat->quantite * $achat->prix_unitaire, 0, ',', ' ') }} F</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Total à payer global -->
            <div class="row justify-content-end mb-4">
              <div class="col-md-4 text-end">
                <div class="p-3 bg-light rounded">
                  <h5 class="mb-1 text-muted small text-uppercase fw-bold">Net à Payer (FCFA) :</h5>
                  <h3 class="text-primary fw-bold mb-0">{{ number_format($achat->quantite * $achat->prix_unitaire, 0, ',', ' ') }} FCFA</h3>
                </div>
              </div>
            </div>

            <!-- Zone de signature pour validation physique -->
            <div class="row pt-5 mt-5 border-top print-only">
              <div class="col-6">
                <p class="small text-muted mb-5">Signature & Cachet du Fournisseur</p>
              </div>
              <div class="col-6 text-end">
                <p class="small text-muted mb-5">Signature de la Direction (G-Pharma)</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Style CSS spécifique pour masquer les superflus au clic sur Imprimer -->
<style>
/* Par défaut sur l'écran, on masque les signatures papier */
.print-only {
  display: none;
}

@media print {
  /* On efface la barre latérale, l'entête global et les boutons */
  .no-print, #header, #sidebar, footer, .btn, .breadcrumb {
    display: none !important;
  }
  
  /* On réinitialise les marges pour prendre toute la page A4 */
  main {
    margin-left: 0 !important;
    padding: 0 !important;
    margin-top: 0 !important;
  }
  
  .card {
    border: none !important;
    box-shadow: none !important;
  }
  
  /* On affiche le bloc signature papier uniquement à l'impression */
  .print-only {
    display: flex !important;
  }
}
</style>
@endsection