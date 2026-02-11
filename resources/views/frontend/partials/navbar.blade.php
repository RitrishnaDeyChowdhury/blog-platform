<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('blog.index') }}">TechTales</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item me-lg-3">
                    <a class="nav-link" href="{{ route('blog.index') }}">Blogs</a>
                </li>

                <!-- Search Bar -->
                <li class="nav-item">
                    <form class="d-flex" method="GET" action="{{ route('blog.search') }}">
                       
                        <input
                            class="form-control me-2 rounded-pill"
                            type="search"
                            name="search"
                            placeholder="Search blogs..."
                            value="{{ request('search') }}"
                        >
                        <button class="btn btn-outline-light" type="submit">
                            Search
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
