@extends('layouts.app')

@section('title', 'Edit Blog')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Blog</h4>
        <form method="POST" action="{{ route('blogs.update' , $blog->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{$blog->category_id == $category->id ? 'selected' : ''}}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required value="{{$blog->title}}">
            </div>
        
            <div class="mb-3">
                <label class="form-label">Featured Image</label>
            
                @if(!empty($blog->featured_image))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Blog Image" id="imagePreview" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                @endif
            
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            </div>
            
        
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" id="editor" required rows="6" class="form-control">{{strip_tags($blog->content)}}</textarea>
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
                                {{ (in_array($tag->id,$attachedTags)) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        
            <button class="btn btn-primary">Update</button>

            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection

<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];

        if (!file) return;

        const imageUrl = URL.createObjectURL(file);

        $('#imagePreview').attr('src', imageUrl).removeClass('d-none');
    }
</script>
