<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow: hidden; /* Prevent body scroll */
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            transition: transform .3s ease;
        }

        .sidebar .nav-link {
            color: var(--bs-body-color);
            border-radius: .5rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
        }

        /* Mobile hidden sidebar */
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                z-index: 1040;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Header */
        .content-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--bs-body-bg);
        }

        /* Scrollable content */
        .content-body {
            overflow-y: auto;
            flex-grow: 1;
            padding: 1rem 2rem;
        }
    </style>
</head>
<body>

<!-- Mobile Navbar -->
<nav class="navbar navbar-dark bg-dark d-lg-none">
    <div class="container-fluid">
        <button id="sidebarToggle" class="btn btn-outline-light">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand">Admin Panel</span>
        <button id="themeToggleMobile" class="btn btn-outline-light">
            <i class="bi bi-moon"></i>
        </button>
    </div>
</nav>

<div class="d-flex vh-100">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-body border-end p-3">
        <div class="d-flex justify-content-between align-items-center mb-4 d-lg-none">
            <strong>Menu</strong>
            <button id="sidebarClose" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <h5 class="mb-4 d-none d-lg-block">Blog Platform</h5>

        <ul class="nav nav-pills flex-column gap-2 mb-auto">
            <li>
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('tags.index') }}" class="nav-link {{ Route::is('tags.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Tags
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-folder2-open"></i> Categories
                </a>
            </li>
            <li>
                <a href="{{ route('blogs.index') }}" class="nav-link {{ Route::is('blogs.*') && !Route::is('blogs.pending') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Blog Posts
                </a>
            </li>
            @auth
            @if(auth()->user()->role === 'admin')
            <li>
                <a href="{{ route('blogs.pending') }}" class="nav-link {{ Route::is('blogs.pending') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square me-2"></i> Pending Posts
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li>
            @endif
            @endauth
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a href="{{ route('logout') }}"
                   class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-power"></i> Logout
                </a>
            </li>
        </ul>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            @auth
            <strong>Hello {{ Str::ucfirst(auth()->user()->name) }}</strong>
            @endauth
            <button id="themeToggle" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-moon"></i>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow-1 d-flex flex-column">
        <!-- Header -->
        <div class="content-header d-none d-lg-flex justify-content-between align-items-center p-3 border-bottom">
            <h6 class="mb-0">@yield('page-title', 'Dashboard')</h6>
            <div class="d-flex">
                <div class="dropdown position-relative mx-4">
                    <button
                        class="btn btn-sm btn-outline-secondary position-relative"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="bi bi-bell"></i>
                    @auth
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  style="font-size: 0.65rem;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    @endauth
                    </button>
                
                    <!-- Dropdown -->
                    <ul class="dropdown-menu dropdown-menu-end shadow"
                        style="width: 320px; max-height: 400px; overflow-y: auto;">
                        
                        <li class="dropdown-header fw-semibold">
                            Notifications
                        </li>
                        @auth
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                            <li>
                                <a href="{{ route('notifications.read', $notification->id)}}"
                                   class="dropdown-item small d-flex gap-2 align-items-start bg-light">
                                    <i class="bi bi-dot text-primary fs-3"></i>
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $notification->data['message'] ?? 'New notification' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-muted small">
                                No new notifications
                            </li>
                        @endforelse
                        @endauth
                
                        <li><hr class="dropdown-divider"></li>
                
                        <li>
                            <a href="{{ route('notifications.show')}}"
                               class="dropdown-item text-center text-primary fw-semibold">
                                View all notifications
                            </a>
                        </li>
                    </ul>
                </div>
                
                <button id="themeToggleDesktop" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-moon"></i>
                </button>
            </div>
            
        </div>

        <!-- Scrollable Content -->
        <div class="content-body">
            @yield('content')
        </div>
    </main>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    const $sidebar = $('#sidebar');
    const $html = $('html');

    // Sidebar toggle (mobile)
    $('#sidebarToggle').on('click', function () {
        $sidebar.addClass('show');
    });

    $('#sidebarClose').on('click', function () {
        $sidebar.removeClass('show');
    });

    // Dark / Light mode
    function setTheme(theme) {
        $html.attr('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
    }

    $('#themeToggle, #themeToggleDesktop, #themeToggleMobile').on('click', function () {
        const currentTheme = $html.attr('data-bs-theme');
        setTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });

    // Set theme on page load
    setTheme(localStorage.getItem('theme') || 'light');
});
</script>

@stack('scripts')

</body>
</html>
