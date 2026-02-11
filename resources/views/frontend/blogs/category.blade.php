@extends('frontend.layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mt-5">

    {{-- Page Title --}}
    <h2 class="mb-4 text-center fw-bold reveal animate__animated animate__fadeInUp">
        Category: {{ $category->name }}
    </h2>

    {{-- Blog Grid --}}
    <div class="row g-4">
        @forelse($blogs as $blog)
            <div class="col-md-6 col-lg-4 reveal animate__animated animate__fadeInUp">
                <div class="card h-100 shadow-sm border-0 hover-effect">

                    {{-- Blog Image --}}
                    @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover; transition: transform 0.3s ease;">
                    @else
                        <img src="{{asset('storage/no-image.jpg')}}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;">
                    @endif

                    {{-- Card Body --}}
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $blog->title }}</h5>
                        <p class="text-muted small mb-2">{{ $blog->created_at->format('M d, Y') }}</p>
                        <p class="card-text">{{ Str::limit($blog->description, 100) }}</p>

                        @if ($blog->tags->isNotEmpty())
                            <div class="mt-2">
                                @foreach ($blog->tags as $tag)
                                    <span class="badge bg-secondary me-1 mb-3">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('blog.show', $blog->slug) }}" 
                           class="btn btn-sm btn-primary d-inline-flex align-items-center">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M10.146 4.146a.5.5 0 0 1 .708.708L7.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-5">No blogs found in this category.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4 reveal animate__animated animate__fadeInUp">
        {{ $blogs->links() }}
    </div>
</div>

{{-- Custom CSS for hover and scroll animations --}}
<style>
    .hover-effect:hover img {
        transform: scale(1.05);
    }

    .hover-effect:hover .card-body {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
</style>

{{-- Scroll reveal JS --}}
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