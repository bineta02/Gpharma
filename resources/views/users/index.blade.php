@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Gestion des utilisateurs</h2>

    <div class="d-flex justify-content-between mb-3">

        <a href="{{ route('users.create') }}"
           class="btn btn-primary">
            Ajouter utilisateur
        </a>

        <form action="{{ route('users.index') }}"
              method="GET">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Rechercher...">

        </form>

    </div>

    @if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif


<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Rôle</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

@forelse($users as $user)

<tr>

<td>{{ $user->id }}</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ ucfirst($user->role) }}</td>

<td>

<a href="{{ route('users.edit',$user->id) }}"
class="btn btn-warning btn-sm">

Modifier

</a>


<form action="{{ route('users.destroy',$user->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">

Supprimer

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="5">

Aucun utilisateur trouvé

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $users->links() }}

</div>

@endsection