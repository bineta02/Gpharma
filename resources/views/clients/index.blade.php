@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Gestion des Clients</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Clients</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Nouveau Client
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
          <div class="card-body pt-3">
            <h5 class="card-title">Liste des Clients enregistrés</h5>

           <div class="table-responsive">
  <table class="table table-hover align-middle datatable">
    <thead class="table-light">
      <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Téléphone</th>
        <th>Email</th>
        <th>Adresse</th>
        <th>Notes</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($clients as $client)
        <tr>
          <!-- 1. Prénom -->
          <td class="fw-bold text-dark">{{ $client->prenom ?? 'N/A' }}</td>
          
          <!-- 2. Nom -->
          <td class="fw-bold text-dark">{{ $client->nom }}</td>
          
          <!-- 3. Téléphone -->
          <td>{{ $client->telephone ?? 'N/A' }}</td>
          
          <!-- 4. Email -->
          <td>{{ $client->email ?? 'N/A' }}</td>
          
          <!-- 5. Adresse -->
          <td>{{ $client->adresse ?? 'N/A' }}</td>
          
          <!-- 6. Notes -->
          <td>
            @if($client->note)
              <span class="text-muted small">{{ $client->note }}</span>
            @else
              <span class="text-muted italic">Aucune note</span>
            @endif
          </td>
          
          <!-- 7. Actions -->
          <td class="text-center">
            <div class="d-flex justify-content-center gap-2">
              <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                <i class="bi bi-pencil"></i>
              </a>
              <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info btn-sm text-white" title="Voir l'historique">
  <i class="bi bi-eye"></i>
</a>
              <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
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