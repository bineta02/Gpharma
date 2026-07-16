@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Journal d'activité</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Historique des actions</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Historique des actions utilisateurs</h5>

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Date & Heure</th>
                                <th>Utilisateur</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Adresse IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <strong>{{ $log->user ? $log->user->name : 'Système' }}</strong>
                                        <br><small class="text-muted">{{ $log->user ? ucfirst($log->user->role) : '' }}</small>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                                    <td>{{ $log->description }}</td>
                                    <td><code>{{ $log->ip_address }}</code></td>
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