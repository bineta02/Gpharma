@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Créer un Utilisateur</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Utilisateurs</a></li>
            <li class="breadcrumb-item active">Nouveau</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informations du nouveau compte</h5>

                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulaire de création -->
                    <form action="{{ route('users.store') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-md-12">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Dupont" required>
                        </div>

                        <div class="col-md-12">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Ex: jean.dupont@gpharma.com" required>
                        </div>

                        <div class="col-md-12">
                            <label for="role" class="form-label">Rôle d'accès</label>
                            <select id="role" name="role" class="form-select" required>
    <option value="" selected disabled>Choisir un rôle...</option>
    @foreach($roles as $role)
        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
    @endforeach
</select>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Créer le compte
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection