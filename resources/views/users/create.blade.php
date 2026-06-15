@extends('layouts.app')

@section('content')

<div class="container">

<h2>Ajouter utilisateur</h2>

<form action="{{route('users.store')}}"
method="POST">

@csrf

<div class="mb-3">

<label>Nom</label>

<input type="text"
name="name"
class="form-control">

</div>


<div class="mb-3">

<label>Email</label>

<input type="email"
name="email"
class="form-control">

</div>


<div class="mb-3">

<label>Mot de passe</label>

<input type="password"
name="password"
class="form-control">

</div>


<div class="mb-3">

<label>Rôle</label>

<select name="role"
class="form-control">

<option value="admin">Admin</option>
<option value="manager">Manager</option>
<option value="user">Utilisateur</option>

</select>

</div>

<button class="btn btn-success">

Enregistrer

</button>

</form>

</div>

@endsection