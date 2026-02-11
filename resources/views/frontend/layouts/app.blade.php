<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TechTales')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            transition: 0.3s;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .nav-link:hover {
            color: #0d6efd !important;
            text-decoration: underline;
        }

        /* Cards */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        /* Blog Title */
        h2, h3, h4, h5 {
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: #212529;
            color: #fff;
            padding: 2rem 0;
        }
        footer a {
            color: #0d6efd;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }

        /* Smooth scroll reveal */
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
</head>
<body>

{{-- Navbar --}}
@include('frontend.partials.navbar')

{{-- Main Content --}}
<div class="container my-5">
    @yield('content')
</div>

{{-- Footer --}}
@include('frontend.partials.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scroll Reveal Script -->
<script>
    // Reveal on scroll
    const reveals = document.querySelectorAll('.reveal');

    function scrollReveal() {
        for(let i = 0; i < reveals.length; i++) {
            const windowHeight = window.innerHeight;
            const elementTop = reveals[i].getBoundingClientRect().top;
            const elementVisible = 100;

            if(elementTop < windowHeight - elementVisible){
                reveals[i].classList.add('active');
            } else {
                reveals[i].classList.remove('active');
            }
        }
    }

    window.addEventListener('scroll', scrollReveal);
    window.addEventListener('load', scrollReveal);
</script>

</body>
</html>
