@extends('master')
@section('title', 'Login')
@section('body')
<div class="col-md-6 offset-md-3 mt-5">
<h2>Login</h2>
@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form method="POST" action="{{ url('/login') }}">
@csrf
<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{
old('email') }}">
</div>
<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control">
</div>
<button type="submit" class="btn btn-primary">Login</button>
</form>
<p class="mt-3">Belum punya akun? <a href="{{ url('/register')
}}">Register di sini</a></p>
</div>
@stop
