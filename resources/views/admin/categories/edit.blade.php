
@extends('layouts.app')

@section('title', 'Edit Categories')

@section('content')
<div class="container mt-4">
    <h3>Edit Category</h3>

    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ $category->name }}"
                   required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>

@endsection
