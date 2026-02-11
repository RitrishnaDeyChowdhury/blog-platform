@extends('layouts.app')

@section('title', 'Create Blog')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Create New Blog</h4>
        <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
        
            <div class="mb-3">
                <label class="form-label">Featured Image</label>
                <input type="file" name="image" class="form-control">
            </div>
        
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" id="editor" rows="6" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <lable class="form-label">Tags</lable>
                @foreach($tags as $tag)
                    <div class="col-md-3 col-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                id="tag{{ $tag->id }}"
                            >
                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        
            <button class="btn btn-primary">Save as Draft</button>

            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection
