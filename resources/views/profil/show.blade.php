@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Profil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Mon Profil</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <!-- Carte d'identité rapide de l'utilisateur -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    <h2>{{ $user->name }}</h2>
                    <h3>{{ ucfirst($user->role) }}</h3>
                    <span class="badge bg-success mt-2">{{ ucfirst($user->statut) }}</span>
                </div>
            </div>
        </div>

        <!-- Onglets d'édition -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Aperçu</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier Infos & Photo</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer Mot de passe</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <!-- Onglet Aperçu -->
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Détails du Profil</h5>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Nom complet</div>
                                <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Adresse Email</div>
                                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Rôle système</div>
                                <div class="col-lg-9 col-md-8">{{ ucfirst($user->role) }}</div>
                            </div>
                        </div>

                        <!-- Onglet Édition -->
                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Photo de profil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                                        <input class="form-control" type="file" id="photo" name="photo">
                                        <small class="text-muted">Fichiers autorisés : jpg, png, jpeg. Max 2Mo.</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-lg-3 col-form-label">Nom complet</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </div>
                            </form>
                        </div>

                        <!-- Onglet Changement de Mot de passe -->
                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            @if(session('success_password'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success_password') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('profil.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="current_password" type="password" class="form-control" id="current_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password_confirmation" class="col-md-4 col-lg-3 col-form-label">Confirmer le mot de passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection