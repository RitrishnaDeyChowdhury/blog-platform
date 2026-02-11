@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4">403</h1>
    <h3>Unauthorized Access</h3>
    <p>You do not have permission to access this page.</p>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        Go Back
    </a>
</div>
@endsection
