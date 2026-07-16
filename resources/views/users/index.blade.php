@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Gestion des Utilisateurs</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Utilisateurs</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <h5 class="card-title">Liste des comptes</h5>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Créer un utilisateur
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Tableau des utilisateurs -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
    <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
</td>
                                    <td>
                                        @if($user->statut === 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Bouton d'édition -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Modifier
                                            </a>

                                            <!-- Formulaire Toggle Statut Actif/Inactif -->
                                            <form action="{{ route('users.toggle', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @if($user->statut === 'actif')
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="bi bi-person-x"></i> Désactiver
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-person-check"></i> Activer
                                                    </button>
                                                @endif
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
</section>
@endsection