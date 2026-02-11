
@extends('layouts.app')

@section('title', 'Create Categories')

@section('content')
<div class="card">
    <div class="card-body shadow-md">
        <h4>Create New Blog</h4>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
    
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Category Name">
            </div>
    
            <button class="btn btn-primary">Create</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection
