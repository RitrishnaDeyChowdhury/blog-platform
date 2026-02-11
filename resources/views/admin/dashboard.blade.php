@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>{{ ucfirst(Auth::user()->name) }} Dashboard</h3>
        <p>Welcome {{ ucfirst(Auth::user()->name) }}</p>
    </div>
</div>
@endsection