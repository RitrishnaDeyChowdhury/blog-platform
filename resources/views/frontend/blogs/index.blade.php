@extends('frontend.layouts.app')

@section('title', 'Latest Blogs')

@section('content')

{{-- Hero Banner --}}
<section class="hero-banner py-5 text-white" style="background: url('{{ asset('storage/hero-banner.avif') }}') center/cover no-repeat;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">Welcome to TechTales</h1>
        <p class="lead animate__animated animate__fadeInUp mt-3">Insights, stories, and inspiration from our writers</p>
        <a href="#latest-blogs" class="btn btn-primary btn-lg mt-4 animate__animated animate__fadeInUp">Explore Blogs</a>
    </div>
</section>

{{-- Categories Section --}}
<section class="categories py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold reveal animate__animated animate__fadeInUp">Blog Categories</h2>
        <div class="row g-3 justify-content-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-3 text-center reveal animate__animated animate__fadeInUp">
                    <a href="{{ route('blog.category', $category->slug) }}" class="category-card d-block py-4 px-2 rounded shadow-sm text-decoration-none text-dark bg-white hover-effect">
                        {{-- Optional Icon for Category --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" class="mb-2" viewBox="0 0 16 16">
                            <path d="M5 10.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            <path d="M3 0h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1zm0 1v14h10V1H3z"/>
                        </svg>
                        <h5 class="mt-2">{{ $category->name }}</h5>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Latest Blogs Section --}}
<section id="latest-blogs" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold reveal animate__animated animate__fadeInUp">Latest Blogs</h2>

        <div class="row g-4">
            @foreach($blogs as $blog)
                <div class="col-md-4 reveal animate__animated animate__fadeInUp">
                    <div class="card h-100 shadow-sm border-0 hover-effect">
                        <img src="{{ $blog->image ?? asset('storage/no-image.jpg') }}" class="card-img-top" style="height:220px; object-fit:cover;">
                        <div class="card-body">
                            <span class="badge bg-primary">{{ $blog->category->name }}</span>
                            <h5 class="card-title mt-2">{{ $blog->title }}</h5>
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

                            <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
</section>

{{-- Custom Styles --}}
<style>
    /* Hero Banner */
    .hero-banner {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-shadow: 0 2px 6px rgba(0,0,0,0.5);
    }

    /* Category Cards */
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    /* Blog Card Hover */
    .hover-effect:hover img {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    .hover-effect:hover .card-body {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

</style>
@endsection

