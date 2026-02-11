
@extends('layouts.app')

@section('title', 'Create Tags')

@section('content')
<div class="card">
    <div class="card-body shadow-md">
        <h4>Create New Tag</h4>
        <form method="POST" action="{{ route('tags.store') }}">
            @csrf
    
            <div class="mb-3">
                <label class="form-label">Tag Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Tag Name">
            </div>
    
            <button class="btn btn-primary">Create</button>
            <a href="{{ route('tags.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection
