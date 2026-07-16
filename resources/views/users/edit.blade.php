@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Modifier l'Utilisateur</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Utilisateurs</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mettre à jour les informations de : {{ $user->name }}</h5>

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

                    <!-- Formulaire de mise à jour -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-12">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-12">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-12">
                            <label for="role" class="form-label">Rôle d'accès</label>
                            <select id="role" name="role" class="form-select" required>
    @foreach($roles as $role)
        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
            {{ ucfirst($role) }}
        </option>
    @endforeach
</select>
                        </div>

                        <!-- Section mot de passe optionnelle -->
                        <div class="col-12 mt-4">
                            <div class="alert alert-info py-2" role="alert">
                                <i class="bi bi-info-circle me-1"></i> Laissez les champs suivants vides si vous ne souhaitez pas modifier le mot de passe.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection