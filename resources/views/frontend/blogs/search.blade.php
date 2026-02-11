@extends('frontend.layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">
        @if($query)
            Search results for: <strong>{{ $query }}</strong>
        @else
            All Blogs
        @endif
    </h4>

    @forelse($blogs as $blog)
        <div class="mb-4 border-bottom pb-2">
            <h5>
                <a href="{{ route('blogs.show', $blog->slug) }}">
                    {{ $blog->title }}
                </a>
            </h5>

            <p class="text-muted">
                Published on {{ $blog->publish_at->format('M d, Y') }}
            </p>

            <p>
                {{ Str::limit(strip_tags($blog->content), 150) }}
            </p>

            @if ($blog->tags->isNotEmpty())
                <div class="mt-2">
                    @foreach ($blog->tags as $tag)
                        <span class="badge bg-secondary me-1 mb-3">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <p>No blogs found.</p>
    @endforelse

    {{ $blogs->links('pagination::bootstrap-5') }}

</div>
@endsection
