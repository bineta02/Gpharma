@extends('layouts.app')

@section('content')
<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Bons d'Achat Fournisseurs</h1>
    </div>
    <a href="{{ route('achats.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Créer un bon d'achat</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <table class="table align-middle backend-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Médicament</th>
        <th>Fournisseur</th>
        <th class="text-center">Quantité</th>
        <th class="text-end">Montant Total</th>
        <th class="text-center">Statut</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($achats as $achat)
        <tr>
          <td>{{ \Carbon\Carbon::parse($achat->created_at)->format('d/m/Y') }}</td>
          <td><strong>{{ $achat->produit->nom ?? 'N/A' }}</strong></td>
          <td>{{ $achat->fournisseur->nom ?? 'N/A' }}</td>
          <td class="text-center">{{ $achat->quantite }}</td>
          <td class="text-end fw-bold">{{ number_format($achat->quantite * $achat->prix_unitaire, 0, ',', ' ') }} F</td>
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
              <a href="{{ route('achats.show', $achat->id) }}" class="btn btn-info btn-sm text-white" title="Détail"><i class="bi bi-eye"></i></a>
              
              @if($achat->statut == 'en_attente')
                <form action="{{ route('achats.receptionner', $achat->id) }}" method="POST">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-success btn-sm" title="Réceptionner/Valider"><i class="bi bi-check-lg"></i></button>
                </form>
              @endif

              @if($achat->statut != 'annule')
                <form action="{{ route('achats.annuler', $achat->id) }}" method="POST" onsubmit="return confirm('Annuler cet achat ? (Le stock sera réajusté)')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-danger btn-sm" title="Annuler"><i class="bi bi-x-circle"></i></button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</main>
@endsection