@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome to the Admin Dashboard </h1>
    <p>This is the main section of your admin panel.</p>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Quick Stats</h5>
            <p class="card-text">Show some statistics here.</p>
        </div>
    </div>

      <h1>Welcome, {{ Auth::user()->name }} 👋</h1>
    <p>You are logged in as an Admin.</p>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>
@endsection
