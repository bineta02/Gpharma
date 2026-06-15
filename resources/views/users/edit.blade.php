@extends('layouts.app')

@section('content')

<div class="container">

<h2>Modifier utilisateur</h2>

<form action="{{route('users.update',$user->id)}}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nom</label>

<input type="text"
name="name"
value="{{$user->name}}"
class="form-control">

</div>


<div class="mb-3">

<label>Email</label>

<input type="email"
name="email"
value="{{$user->email}}"
class="form-control">

</div>


<div class="mb-3">

<label>Rôle</label>

<select name="role"
class="form-control">

<option value="admin"
{{$user->role=='admin' ? 'selected':''}}>
Admin
</option>

<option value="manager"
{{$user->role=='manager' ? 'selected':''}}>
Manager
</option>

<option value="user"
{{$user->role=='user' ? 'selected':''}}>
Utilisateur
</option>

</select>

</div>

<button class="btn btn-primary">

Modifier

</button>

</form>

</div>

@endsection