@extends('frontend.layouts.app')

@section('title', $blog->title)

@section('content')
<div class="row mt-5">

    {{-- Main Blog Content --}}
    <div class="col-lg-8 reveal animate__animated animate__fadeInUp">

        {{-- Blog Title --}}
        <h1 class="fw-bold mb-3">{{ $blog->title }}</h1>

        {{-- Meta Info --}}
        <p class="text-muted mb-4">
            {{ $blog->created_at->format('M d, Y') }} | 
            <a href="{{ route('blog.category', $blog->category->slug) }}" class="text-decoration-none">
                {{ $blog->category->name }}
            </a>
        </p>

        {{-- Blog Image --}}
        <img src="{{ $blog->featured_image 
            ? asset('storage/' . $blog->featured_image) 
            : asset('storage/no-image.jpg') 
        }}" 
        class="img-fluid rounded mb-4 shadow-sm" 
        style="height:400px; object-fit:cover;" 
        alt="{{ $blog->title }}">

        {{-- Blog Content --}}
        <div class="mb-5">
            <p>{!! nl2br(e($blog->content)) !!}</p>
        </div>

        @if ($blog->tags->isNotEmpty())
            <div class="mt-2">
                @foreach ($blog->tags as $tag)
                    <span class="badge bg-secondary me-1 mb-3">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Customer Reviews --}}
        <hr>
        <h4 class="mb-3">Customer Reviews</h4>

        {{-- @forelse($blog->reviews as $review)
            <div class="border rounded p-3 mb-3 shadow-sm">
                <strong>{{ $review->name }}</strong>
                <p class="mb-0">{{ $review->message }}</p>
            </div>
        @empty
            <p class="text-muted">No reviews yet. Be the first to review!</p>
        @endforelse --}}

        {{-- Add Review Form --}}
        <h5 class="mt-4 mb-3">Add Your Review</h5> 
        {{-- {{ route('review.store', $blog->id) }} --}}
        <form method="POST" action="">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="3" placeholder="Your Review" required></textarea>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>

    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4 reveal animate__animated animate__fadeInUp">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Categories</h5>
                <ul class="list-unstyled">
                    @foreach($categories as $cat)
                        <li class="mb-2">
                            <a href="{{ route('blog.category', $cat->slug) }}" class="text-decoration-none text-primary">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Related Blogs based on Category--}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Related Blogs</h5>
                <ul class="list-unstyled">
                    @foreach($relatedBlogs as $related)
                        <li class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                <path d="M5 10.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                <path d="M3 0h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1zm0 1v14h10V1H3z"/>
                            </svg>
                            <a href="{{route('blog.show', $related->slug)}}" class="text-decoration-none">
                             {{ $related->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</div>

{{-- Scroll Reveal & Hover Animations --}}
<style>
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    .card:hover img {
        transform: scale(1.03);
        transition: transform 0.3s ease;
    }
</style>

@endsection

<script>
    const reveals = document.querySelectorAll('.reveal');
    function scrollReveal() {
        for (let i = 0; i < reveals.length; i++) {
            const windowHeight = window.innerHeight;
            const elementTop = reveals[i].getBoundingClientRect().top;
            const elementVisible = 100;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add('active');
            } else {
                reveals[i].classList.remove('active');
            }
        }
    }
    window.addEventListener('scroll', scrollReveal);
    window.addEventListener('load', scrollReveal);
</script>